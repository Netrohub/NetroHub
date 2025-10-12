<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebhookLogResource\Pages;
use App\Models\WebhookLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class WebhookLogResource extends Resource
{
    protected static ?string $model = WebhookLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    
    protected static ?string $navigationGroup = 'System';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $navigationLabel = 'Webhook Logs';

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_webhooks');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Webhook Information')
                    ->schema([
                        Forms\Components\TextInput::make('event')
                            ->disabled(),
                        
                        Forms\Components\TextInput::make('status')
                            ->disabled(),
                        
                        Forms\Components\TextInput::make('attempts')
                            ->numeric()
                            ->disabled(),
                        
                        Forms\Components\DateTimePicker::make('processed_at')
                            ->disabled(),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Payload')
                    ->schema([
                        Forms\Components\Textarea::make('payload')
                            ->disabled()
                            ->rows(10)
                            ->columnSpanFull()
                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT) : $state),
                    ]),
                
                Forms\Components\Section::make('Error Details')
                    ->schema([
                        Forms\Components\Textarea::make('error_message')
                            ->disabled()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record && $record->status === 'failed'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('event')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'processed',
                        'warning' => 'pending',
                        'danger' => 'failed',
                    ]),
                
                Tables\Columns\TextColumn::make('attempts')
                    ->label('Tries')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('processed_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processed' => 'Processed',
                        'failed' => 'Failed',
                    ]),
                
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                
                Tables\Actions\Action::make('replay')
                    ->label('Replay')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (WebhookLog $record) {
                        // TODO: Implement webhook replay logic
                        Notification::make()
                            ->success()
                            ->title('Webhook replayed')
                            ->body('The webhook has been queued for reprocessing')
                            ->send();
                    })
                    ->visible(fn () => auth()->user()->can('replay_webhooks')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->can('replay_webhooks')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebhookLogs::route('/'),
            'view' => Pages\ViewWebhookLog::route('/{record}'),
        ];
    }
}
