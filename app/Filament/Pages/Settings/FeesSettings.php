<?php

namespace App\Filament\Pages\Settings;

use App\Models\AdminAudit;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class FeesSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string $view = 'filament.pages.settings.fees-settings';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $navigationLabel = 'Fees & Commission';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getSettingsArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Platform Fees')
                    ->schema([
                        Forms\Components\TextInput::make('platform_fee_percentage')
                            ->label('Platform Fee (%)')
                            ->numeric()
                            ->suffix('%')
                            ->required()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(10)
                            ->helperText('Percentage taken from each sale'),
                        
                        Forms\Components\TextInput::make('minimum_fee')
                            ->label('Minimum Fee ($)')
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0)
                            ->default(0.50),
                        
                        Forms\Components\TextInput::make('maximum_fee')
                            ->label('Maximum Fee ($)')
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0)
                            ->helperText('Leave empty for no maximum'),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Payout Settings')
                    ->schema([
                        Forms\Components\TextInput::make('minimum_payout')
                            ->label('Minimum Payout Amount ($)')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->minValue(0)
                            ->default(10)
                            ->helperText('Minimum balance required to request payout'),
                        
                        Forms\Components\TextInput::make('payout_processing_fee')
                            ->label('Payout Processing Fee ($)')
                            ->numeric()
                            ->prefix('$')
                            ->default(1.00)
                            ->helperText('Fee charged for each payout'),
                        
                        Forms\Components\TextInput::make('payout_schedule_days')
                            ->label('Payout Schedule (Days)')
                            ->numeric()
                            ->suffix('days')
                            ->default(7)
                            ->helperText('Standard processing time for payouts'),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Subscription Discounts')
                    ->description('Fee discounts for premium subscribers')
                    ->schema([
                        Forms\Components\TextInput::make('plus_fee_discount')
                            ->label('Plus Plan Discount (%)')
                            ->numeric()
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(10)
                            ->helperText('Fee reduction for Plus subscribers'),
                        
                        Forms\Components\TextInput::make('pro_fee_discount')
                            ->label('Pro Plan Discount (%)')
                            ->numeric()
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(25)
                            ->helperText('Fee reduction for Pro subscribers'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getSettingsArray(): array
    {
        return [
            'platform_fee_percentage' => Setting::get('platform_fee_percentage', 10),
            'minimum_fee' => Setting::get('minimum_fee', 0.50),
            'maximum_fee' => Setting::get('maximum_fee'),
            'minimum_payout' => Setting::get('minimum_payout', 10),
            'payout_processing_fee' => Setting::get('payout_processing_fee', 1.00),
            'payout_schedule_days' => Setting::get('payout_schedule_days', 7),
            'plus_fee_discount' => Setting::get('plus_fee_discount', 10),
            'pro_fee_discount' => Setting::get('pro_fee_discount', 25),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            $type = is_numeric($value) && !is_string($value) ? 'float' : 'string';
            Setting::set($key, $value, 'fees', $type);
        }

        AdminAudit::log(
            auth()->user(),
            'fees_settings_updated',
            null,
            null,
            $data
        );

        Setting::clearCache();

        Notification::make()
            ->success()
            ->title('Fee settings saved')
            ->send();
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_settings');
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label('Save Fee Settings')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }
}

