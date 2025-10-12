<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayoutRequestResource\Pages;
use App\Models\AdminAudit;
use App\Models\PayoutRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PayoutRequestResource extends Resource
{
    protected static ?string $model = PayoutRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Money';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('seller.display_name')->searchable(),
            Tables\Columns\TextColumn::make('seller.user.email')->searchable(),
            Tables\Columns\TextColumn::make('amount')->money('USD')->sortable(),
            Tables\Columns\TextColumn::make('payout_method'),
            Tables\Columns\TextColumn::make('status')->badge()->colors([
                'warning' => 'pending',
                'success' => 'completed',
                'danger' => 'rejected',
            ])->sortable(),
            Tables\Columns\TextColumn::make('created_at')->label('Requested')->dateTime()->sortable(),
            Tables\Columns\TextColumn::make('processed_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status'),
        ])->actions([
            Tables\Actions\ActionGroup::make([
                Tables\Actions\Action::make('approve')->icon('heroicon-o-check-circle')->color('success')
                    ->visible(fn (PayoutRequest $r) => $r->status === 'pending')
                    ->form([
                        Forms\Components\TextInput::make('transaction_reference')->label('Transaction ID')->required(),
                        Forms\Components\Textarea::make('notes'),
                    ])
                    ->action(function (PayoutRequest $r, array $data) {
                        $r->approve(auth()->user(), $data['transaction_reference']);
                        AdminAudit::log(auth()->user(), 'approved_payout', $r);
                        Notification::make()->success()->title('Payout Approved')->send();
                    })
                    ->visible(fn () => auth()->user()->can('approve_payouts')),
                Tables\Actions\Action::make('reject')->icon('heroicon-o-x-circle')->color('danger')
                    ->visible(fn (PayoutRequest $r) => $r->status === 'pending')
                    ->form([Forms\Components\Textarea::make('reason')->required()])
                    ->action(function (PayoutRequest $r, array $data) {
                        $r->reject(auth()->user(), $data['reason']);
                        AdminAudit::log(auth()->user(), 'rejected_payout', $r);
                        Notification::make()->danger()->title('Payout Rejected')->send();
                    })
                    ->visible(fn () => auth()->user()->can('reject_payouts')),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayoutRequests::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_payouts');
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
