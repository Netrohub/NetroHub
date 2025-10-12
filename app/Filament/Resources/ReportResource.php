<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\AdminAudit;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    
    protected static ?string $navigationGroup = 'Moderation';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $navigationLabel = 'Reports';

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_reports');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Report Information')
                    ->schema([
                        Forms\Components\Select::make('reporter_id')
                            ->relationship('reporter', 'name')
                            ->searchable()
                            ->disabled(),
                        
                        Forms\Components\TextInput::make('reportable_type')
                            ->label('Type')
                            ->disabled(),
                        
                        Forms\Components\TextInput::make('reason')
                            ->disabled(),
                        
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Moderation')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'reviewing' => 'Reviewing',
                                'dismissed' => 'Dismissed',
                                'actioned' => 'Actioned',
                            ])
                            ->required(),
                        
                        Forms\Components\Textarea::make('moderator_notes')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Internal notes visible only to moderators'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('reporter.name')
                    ->label('Reporter')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('reportable_type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->badge()
                    ->color('gray'),
                
                Tables\Columns\TextColumn::make('reason')
                    ->searchable()
                    ->limit(30),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'reviewing',
                        'success' => 'dismissed',
                        'danger' => 'actioned',
                    ]),
                
                Tables\Columns\TextColumn::make('reviewer.name')
                    ->label('Reviewed By')
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reported')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('reviewed_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewing' => 'Reviewing',
                        'dismissed' => 'Dismissed',
                        'actioned' => 'Actioned',
                    ])
                    ->default('pending'),
                
                Tables\Filters\SelectFilter::make('reportable_type')
                    ->label('Type')
                    ->options([
                        'App\Models\Review' => 'Review',
                        'App\Models\Product' => 'Product',
                        'App\Models\User' => 'User',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    
                    Tables\Actions\Action::make('review')
                        ->label('Start Review')
                        ->icon('heroicon-o-eye')
                        ->color('primary')
                        ->visible(fn (Report $record) => $record->status === 'pending')
                        ->action(function (Report $record) {
                            $record->update(['status' => 'reviewing']);
                            AdminAudit::log(auth()->user(), 'report_review_started', $record);
                            Notification::make()->success()->title('Review started')->send();
                        }),
                    
                    Tables\Actions\Action::make('dismiss')
                        ->label('Dismiss')
                        ->icon('heroicon-o-x-circle')
                        ->color('success')
                        ->form([
                            Forms\Components\Textarea::make('moderator_notes')
                                ->label('Reason for dismissal')
                                ->required()
                                ->rows(3),
                        ])
                        ->action(function (Report $record, array $data) {
                            $record->markAsReviewed(auth()->user(), 'dismissed', $data['moderator_notes']);
                            AdminAudit::log(auth()->user(), 'report_dismissed', $record, null, $data);
                            Notification::make()->success()->title('Report dismissed')->send();
                        })
                        ->visible(fn () => auth()->user()->can('moderate_reports')),
                    
                    Tables\Actions\Action::make('action_taken')
                        ->label('Mark Actioned')
                        ->icon('heroicon-o-check-circle')
                        ->color('danger')
                        ->form([
                            Forms\Components\Textarea::make('moderator_notes')
                                ->label('Action taken')
                                ->required()
                                ->rows(3),
                        ])
                        ->action(function (Report $record, array $data) {
                            $record->markAsReviewed(auth()->user(), 'actioned', $data['moderator_notes']);
                            AdminAudit::log(auth()->user(), 'report_actioned', $record, null, $data);
                            Notification::make()->success()->title('Report marked as actioned')->send();
                        })
                        ->visible(fn () => auth()->user()->can('moderate_reports')),
                    
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_reviewing')
                        ->label('Mark as Reviewing')
                        ->icon('heroicon-o-eye')
                        ->action(fn ($records) => $records->each->update(['status' => 'reviewing']))
                        ->deselectRecordsAfterCompletion(),
                    
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->can('moderate_reports')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'view' => Pages\ViewReport::route('/{record}'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
