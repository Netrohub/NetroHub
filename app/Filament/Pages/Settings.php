<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Platform';

    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'platform_commission_percent' => Setting::where('key', 'platform_commission_percent')->value('value') ?? '10',
            'platform_name' => Setting::where('key', 'platform_name')->value('value') ?? 'NetroHub',
            'min_payout_amount' => Setting::where('key', 'min_payout_amount')->value('value') ?? '50',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Marketplace Settings')
                    ->schema([
                        Forms\Components\TextInput::make('platform_commission_percent')
                            ->label('Platform Commission (%)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('min_payout_amount')
                            ->label('Minimum Payout Amount ($)')
                            ->numeric()
                            ->required()
                            ->minValue(0),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Platform Identity')
                    ->schema([
                        Forms\Components\TextInput::make('platform_name')
                            ->label('Platform Name')
                            ->required(),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->action('save'),
        ];
    }

    public function save(): void
    {
        if (! auth()->user()->can('edit_settings')) {
            Notification::make()->danger()->title('Access Denied')->send();

            return;
        }

        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => is_numeric($value) ? 'integer' : 'string']
            );
        }

        Notification::make()
            ->success()
            ->title('Settings saved successfully')
            ->send();
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_settings');
    }
}
