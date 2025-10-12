<?php

namespace App\Filament\Pages\Settings;

use App\Models\AdminAudit;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class SecuritySettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static string $view = 'filament.pages.settings.security-settings';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 3;
    
    protected static ?string $navigationLabel = 'Security';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getSettingsArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Cloudflare Turnstile')
                    ->description('Bot protection for forms')
                    ->schema([
                        Forms\Components\TextInput::make('turnstile_site_key')
                            ->label('Site Key')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('turnstile_secret_key')
                            ->label('Secret Key')
                            ->password()
                            ->maxLength(255),
                        
                        Forms\Components\Toggle::make('turnstile_enabled')
                            ->label('Enable Turnstile')
                            ->default(false),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Login Security')
                    ->schema([
                        Forms\Components\TextInput::make('max_login_attempts')
                            ->label('Max Login Attempts')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->default(5),
                        
                        Forms\Components\TextInput::make('login_lockout_minutes')
                            ->label('Lockout Duration (Minutes)')
                            ->numeric()
                            ->required()
                            ->suffix('min')
                            ->minValue(1)
                            ->default(15),
                        
                        Forms\Components\Toggle::make('require_email_verification')
                            ->label('Require Email Verification')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('enable_2fa')
                            ->label('Enable Two-Factor Authentication')
                            ->default(false)
                            ->helperText('Allow users to enable 2FA'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Password Policy')
                    ->schema([
                        Forms\Components\TextInput::make('min_password_length')
                            ->label('Minimum Password Length')
                            ->numeric()
                            ->required()
                            ->minValue(6)
                            ->maxValue(128)
                            ->default(8),
                        
                        Forms\Components\Toggle::make('password_require_uppercase')
                            ->label('Require Uppercase')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('password_require_lowercase')
                            ->label('Require Lowercase')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('password_require_numbers')
                            ->label('Require Numbers')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('password_require_symbols')
                            ->label('Require Symbols')
                            ->default(false),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Rate Limiting')
                    ->schema([
                        Forms\Components\TextInput::make('api_rate_limit')
                            ->label('API Rate Limit (per minute)')
                            ->numeric()
                            ->required()
                            ->default(60),
                        
                        Forms\Components\TextInput::make('download_rate_limit')
                            ->label('Download Rate Limit (per hour)')
                            ->numeric()
                            ->required()
                            ->default(10),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getSettingsArray(): array
    {
        return [
            'turnstile_site_key' => Setting::get('turnstile_site_key'),
            'turnstile_secret_key' => Setting::get('turnstile_secret_key'),
            'turnstile_enabled' => Setting::get('turnstile_enabled', false),
            'max_login_attempts' => Setting::get('max_login_attempts', 5),
            'login_lockout_minutes' => Setting::get('login_lockout_minutes', 15),
            'require_email_verification' => Setting::get('require_email_verification', true),
            'enable_2fa' => Setting::get('enable_2fa', false),
            'min_password_length' => Setting::get('min_password_length', 8),
            'password_require_uppercase' => Setting::get('password_require_uppercase', true),
            'password_require_lowercase' => Setting::get('password_require_lowercase', true),
            'password_require_numbers' => Setting::get('password_require_numbers', true),
            'password_require_symbols' => Setting::get('password_require_symbols', false),
            'api_rate_limit' => Setting::get('api_rate_limit', 60),
            'download_rate_limit' => Setting::get('download_rate_limit', 10),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            $type = is_bool($value) ? 'boolean' : (is_numeric($value) ? 'integer' : 'string');
            Setting::set($key, $value, 'security', $type);
        }

        AdminAudit::log(
            auth()->user(),
            'security_settings_updated',
            null,
            null,
            $data
        );

        Setting::clearCache();

        Notification::make()
            ->success()
            ->title('Security settings saved')
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
                ->label('Save Security Settings')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }
}

