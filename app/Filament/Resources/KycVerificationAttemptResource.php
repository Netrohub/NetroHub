<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KycVerificationAttemptResource\Pages;
use App\Filament\Resources\KycVerificationAttemptResource\RelationManagers;
use App\Models\KycVerificationAttempt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KycVerificationAttemptResource extends Resource
{
    protected static ?string $model = KycVerificationAttempt::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    
    protected static ?string $navigationLabel = 'KYC Verifications';
    
    protected static ?string $modelLabel = 'KYC Verification';
    
    protected static ?string $pluralModelLabel = 'KYC Verifications';
    
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Seller Information')
            ->schema([
                Forms\Components\Select::make('seller_id')
                            ->relationship('seller', 'display_name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Placeholder::make('seller_info')
                            ->label('Seller Details')
                            ->content(function ($record) {
                                if (!$record || !$record->seller) return 'N/A';
                                $seller = $record->seller;
                                return "Name: {$seller->user->name}\nEmail: {$seller->user->email}\nDisplay Name: {$seller->display_name}";
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('KYC Details')
                    ->schema([
                        Forms\Components\TextInput::make('kyc_full_name')
                            ->label('Full Name')
                            ->disabled()
                            ->dehydrated(false)
                            ->default(fn ($record) => $record?->seller?->kyc_full_name),
                        Forms\Components\TextInput::make('kyc_country')
                            ->label('Country')
                            ->disabled()
                            ->dehydrated(false)
                            ->default(fn ($record) => $record?->seller?->kyc_country),
                        Forms\Components\TextInput::make('kyc_id_type')
                            ->label('ID Type')
                            ->disabled()
                            ->dehydrated(false)
                            ->default(fn ($record) => ucfirst(str_replace('_', ' ', $record?->seller?->kyc_id_type ?? ''))),
                        Forms\Components\TextInput::make('kyc_id_number')
                            ->label('ID Number')
                            ->disabled()
                            ->dehydrated(false)
                            ->default(fn ($record) => $record?->seller?->kyc_id_number ? '••••••••' : 'N/A'),
                    ])->columns(2),

                Forms\Components\Section::make('Documents')
                    ->schema([
                        Forms\Components\Placeholder::make('id_front')
                            ->label('ID Front')
                            ->content(function ($record) {
                                if (!$record || !$record->seller?->kyc_id_front_url) {
                                    return new \Illuminate\Support\HtmlString('<div class="text-gray-500 italic">No document uploaded</div>');
                                }
                                
                                $filename = basename($record->seller->kyc_id_front_url);
                                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                $documentUrl = route('admin.kyc.document', ['file' => $record->seller->kyc_id_front_url, 'type' => 'front']);
                                
                                if ($isImage) {
                                    return new \Illuminate\Support\HtmlString('
                                        <div class="space-y-2">
                                            <div class="relative">
                                                <img src="' . $documentUrl . '" 
                                                     alt="ID Front Document" 
                                                     class="max-w-full h-auto rounded-lg border border-gray-300 shadow-sm cursor-pointer hover:shadow-md transition-shadow"
                                                     style="max-height: 300px;"
                                                     onclick="window.open(\'' . $documentUrl . '\', \'_blank\')">
                                                <div class="absolute top-2 right-2">
                                                    <button type="button" 
                                                            class="bg-blue-500 text-white p-1 rounded-full hover:bg-blue-600 transition-colors"
                                                            onclick="window.open(\'' . $documentUrl . '\', \'_blank\')"
                                                            title="View Full Size">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <span class="font-medium">File:</span> ' . $filename . '
                                            </div>
                                        </div>
                                    ');
                                } else {
                                    return new \Illuminate\Support\HtmlString('
                                        <div class="border border-gray-300 rounded-lg p-4 text-center">
                                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-sm text-gray-600 mb-2">' . strtoupper($extension) . ' Document</p>
                                            <a href="' . $documentUrl . '" 
                                               target="_blank"
                                               class="inline-flex items-center px-3 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                                View Document
                                            </a>
                                            <div class="text-xs text-gray-500 mt-2">
                                                <span class="font-medium">File:</span> ' . $filename . '
                                            </div>
                                        </div>
                                    ');
                                }
                            }),
                        Forms\Components\Placeholder::make('id_back')
                            ->label('ID Back')
                            ->content(function ($record) {
                                if (!$record || !$record->seller?->kyc_id_back_url) {
                                    return new \Illuminate\Support\HtmlString('<div class="text-gray-500 italic">No document uploaded</div>');
                                }
                                
                                $filename = basename($record->seller->kyc_id_back_url);
                                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                $documentUrl = route('admin.kyc.document', ['file' => $record->seller->kyc_id_back_url, 'type' => 'back']);
                                
                                if ($isImage) {
                                    return new \Illuminate\Support\HtmlString('
                                        <div class="space-y-2">
                                            <div class="relative">
                                                <img src="' . $documentUrl . '" 
                                                     alt="ID Back Document" 
                                                     class="max-w-full h-auto rounded-lg border border-gray-300 shadow-sm cursor-pointer hover:shadow-md transition-shadow"
                                                     style="max-height: 300px;"
                                                     onclick="window.open(\'' . $documentUrl . '\', \'_blank\')">
                                                <div class="absolute top-2 right-2">
                                                    <button type="button" 
                                                            class="bg-blue-500 text-white p-1 rounded-full hover:bg-blue-600 transition-colors"
                                                            onclick="window.open(\'' . $documentUrl . '\', \'_blank\')"
                                                            title="View Full Size">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <span class="font-medium">File:</span> ' . $filename . '
                                            </div>
                                        </div>
                                    ');
                                } else {
                                    return new \Illuminate\Support\HtmlString('
                                        <div class="border border-gray-300 rounded-lg p-4 text-center">
                                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-sm text-gray-600 mb-2">' . strtoupper($extension) . ' Document</p>
                                            <a href="' . $documentUrl . '" 
                                               target="_blank"
                                               class="inline-flex items-center px-3 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                                View Document
                                            </a>
                                            <div class="text-xs text-gray-500 mt-2">
                                                <span class="font-medium">File:</span> ' . $filename . '
                                            </div>
                                        </div>
                                    ');
                                }
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('Review')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'submitted' => 'Submitted',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                    ->required()
                            ->default('submitted'),
                Forms\Components\Textarea::make('admin_notes')
                            ->label('Admin Notes')
                            ->rows(3)
                            ->placeholder('Internal notes for this verification...'),
                Forms\Components\Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->rows(3)
                            ->placeholder('Reason for rejection (if applicable)...')
                            ->visible(fn ($get) => $get('status') === 'rejected'),
                        Forms\Components\Placeholder::make('reviewed_at_display')
                            ->label('Reviewed At')
                            ->content(function ($record) {
                                return $record?->reviewed_at 
                                    ? $record->reviewed_at->format('M j, Y \a\t g:i A')
                                    : 'Not reviewed yet';
                            }),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('seller.user.name')
                    ->label('User Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('seller.user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('seller.kyc_full_name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('seller.kyc_country')
                    ->label('Country')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('seller.kyc_id_type')
                    ->label('ID Type')
                    ->formatStateUsing(fn ($state) => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_documents')
                    ->label('Documents')
                    ->getStateUsing(function ($record) {
                        return !empty($record->seller?->kyc_id_front_url);
                    })
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'submitted',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewed_at')
                    ->label('Reviewed')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewedBy.name')
                    ->label('Reviewed By')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Submitted',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\Filter::make('submitted_at')
                    ->form([
                        Forms\Components\DatePicker::make('submitted_from'),
                        Forms\Components\DatePicker::make('submitted_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['submitted_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('submitted_at', '>=', $date),
                            )
                            ->when(
                                $data['submitted_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('submitted_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('submitted_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKycVerificationAttempts::route('/'),
            'create' => Pages\CreateKycVerificationAttempt::route('/create'),
            'edit' => Pages\EditKycVerificationAttempt::route('/{record}/edit'),
        ];
    }
}
