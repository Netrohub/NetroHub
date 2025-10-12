<?php

namespace App\Filament\Pages\Settings;

use App\Models\AdminAudit;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class GeneralSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.settings.general-settings';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $navigationLabel = 'General Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getSettingsArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Branding')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\FileUpload::make('site_logo')
                            ->label('Site Logo')
                            ->image()
                            ->directory('settings'),
                        
                        Forms\Components\FileUpload::make('site_favicon')
                            ->label('Favicon')
                            ->image()
                            ->directory('settings'),
                        
                        Forms\Components\ColorPicker::make('primary_color')
                            ->label('Primary Color'),
                        
                        Forms\Components\Textarea::make('site_description')
                            ->label('Site Description')
                            ->rows(3),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('contact_email')
                            ->email()
                            ->required(),
                        
                        Forms\Components\TextInput::make('support_email')
                            ->email()
                            ->required(),
                        
                        Forms\Components\TextInput::make('admin_email')
                            ->email()
                            ->required(),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Email Settings')
                    ->schema([
                        Forms\Components\TextInput::make('mail_from_name')
                            ->label('From Name')
                            ->required(),
                        
                        Forms\Components\TextInput::make('mail_from_address')
                            ->label('From Email')
                            ->email()
                            ->required(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getSettingsArray(): array
    {
        return [
            'site_name' => Setting::get('site_name', 'NetroHub'),
            'site_logo' => Setting::get('site_logo'),
            'site_favicon' => Setting::get('site_favicon'),
            'primary_color' => Setting::get('primary_color', '#3b82f6'),
            'site_description' => Setting::get('site_description'),
            'contact_email' => Setting::get('contact_email', 'contact@netrohub.com'),
            'support_email' => Setting::get('support_email', 'support@netrohub.com'),
            'admin_email' => Setting::get('admin_email', 'admin@netrohub.com'),
            'mail_from_name' => Setting::get('mail_from_name', 'NetroHub'),
            'mail_from_address' => Setting::get('mail_from_address', 'noreply@netrohub.com'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'branding', is_bool($value) ? 'boolean' : 'string');
        }

        AdminAudit::log(
            auth()->user(),
            'settings_updated',
            null,
            null,
            $data
        );

        Notification::make()
            ->success()
            ->title('Settings saved')
            ->send();
    }

    public function publishSettings(): void
    {
        Setting::clearCache();
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        AdminAudit::log(
            auth()->user(),
            'settings_published',
            null,
            null,
            ['action' => 'cache_cleared']
        );

        Notification::make()
            ->success()
            ->title('Settings published')
            ->body('All caches cleared')
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
                ->label('Save Settings')
                ->submit('save')
                ->keyBindings(['mod+s']),
            
            Forms\Components\Actions\Action::make('publish')
                ->label('Publish & Clear Cache')
                ->color('success')
                ->icon('heroicon-o-rocket-launch')
                ->action('publishSettings')
                ->requiresConfirmation()
                ->visible(fn () => auth()->user()->can('publish_settings')),
        ];
    }
}

