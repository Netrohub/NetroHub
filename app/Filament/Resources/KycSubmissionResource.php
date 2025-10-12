<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KycSubmissionResource\Pages;
use App\Models\KycSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class KycSubmissionResource extends Resource
{
    protected static ?string $model = KycSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    
    protected static ?string $navigationLabel = 'KYC Submissions';
    
    protected static ?string $modelLabel = 'KYC Submission';
    
    protected static ?string $pluralModelLabel = 'KYC Submissions';
    
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Placeholder::make('user_info')
                            ->label('User Details')
                            ->content(function ($record) {
                                if (!$record || !$record->user) return 'N/A';
                                $user = $record->user;
                                $phone = $user->phone_number ?: 'Not provided';
                                return "Email: {$user->email}\nPhone: {$phone}\nVerified: " . ($user->is_verified ? 'Yes' : 'No');
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('KYC Details')
                    ->schema([
                        Forms\Components\TextInput::make('country_code')
                            ->label('Country')
                            ->required()
                            ->maxLength(2)
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('full_name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\DatePicker::make('dob')
                            ->label('Date of Birth')
                            ->required()
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('id_type')
                            ->label('ID Type')
                            ->required()
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(2),

                Forms\Components\Section::make('Document')
                    ->schema([
                        Forms\Components\Placeholder::make('document_preview')
                            ->label('ID Document')
                            ->content(function ($record) {
                                if (!$record || !$record->id_image_path) return 'No document uploaded';
                                
                                try {
                                    $decryptedPath = $record->getDecryptedImagePath();
                                    if (!$decryptedPath || !Storage::disk('private')->exists($decryptedPath)) {
                                        return 'Document not found';
                                    }
                                    
                                    $filename = basename($decryptedPath);
                                    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    $documentUrl = route('admin.kyc.document', ['file' => $decryptedPath, 'type' => 'kyc']);
                                    
                                    if ($isImage) {
                                        return new \Illuminate\Support\HtmlString('
                                            <div class="space-y-2">
                                                <div class="relative">
                                                    <img src="' . $documentUrl . '" 
                                                         alt="ID Document" 
                                                         class="max-w-full h-auto rounded-lg border border-gray-300 shadow-sm cursor-pointer hover:shadow-md transition-shadow"
                                                         style="max-height: 300px;"
                                                         onclick="window.open(\'' . $documentUrl . '\', \'_blank\')">
                                                    <div class="absolute top-2 right-2">
                                                        <button type="button" 
                                                                class="bg-blue-500 text-white p-1 rounded-full hover:bg-blue-600 transition-colors"
                                                                onclick="window.open(\'' . $documentUrl . '\', \'_blank\')"
                                                                title="View Full Size">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0118 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
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
                                } catch (\Exception $e) {
                                    Log::error('Error displaying KYC document', ['error' => $e->getMessage()]);
                                    return 'Error loading document';
                                }
                            }),
                    ]),

                Forms\Components\Section::make('Review')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\Textarea::make('notes')
                            ->label('Admin Notes')
                            ->rows(3)
                            ->placeholder('Internal notes for this verification...'),
                        Forms\Components\Placeholder::make('reviewed_info')
                            ->label('Review Information')
                            ->content(function ($record) {
                                if (!$record) return 'Not reviewed yet';
                                
                                $reviewer = $record->reviewer ? $record->reviewer->name : 'Unknown';
                                $reviewedAt = $record->reviewed_at ? $record->reviewed_at->format('M j, Y \a\t g:i A') : 'Not reviewed';
                                
                                return "Reviewed by: {$reviewer}\nReviewed at: {$reviewedAt}";
                            }),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country_code')
                    ->label('Country')
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_type')
                    ->label('ID Type')
                    ->formatStateUsing(fn ($state) => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewed_at')
                    ->label('Reviewed')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewer.name')
                    ->label('Reviewed By')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['reviewed_by'] = auth()->id();
                        $data['reviewed_at'] = now();
                        return $data;
                    })
                    ->after(function ($record, array $data) {
                        // Use the centralized status update handler
                        \App\Http\Controllers\Account\KycController::handleStatusUpdate(
                            $record, 
                            $data['status'], 
                            $data['notes'] ?? null
                        );
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListKycSubmissions::route('/'),
            'create' => Pages\CreateKycSubmission::route('/create'),
            'edit' => Pages\EditKycSubmission::route('/{record}/edit'),
        ];
    }
}