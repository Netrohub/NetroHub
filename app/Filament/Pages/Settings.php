<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationGroup = 'System';
    
    protected static ?int $navigationSort = 99;
    
    protected static string $view = 'filament.pages.settings';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill([
            'site_name' => \App\Models\SiteSetting::get('site_name', 'NetroHub'),
            'site_description' => \App\Models\SiteSetting::get('site_description', 'The ultimate gaming marketplace'),
            'admin_theme' => \App\Models\SiteSetting::get('admin_theme', 'system'),
            'enable_dark_mode' => \App\Models\SiteSetting::get('enable_dark_mode', true),
        ]);
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Settings')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),
                        
                        Textarea::make('site_description')
                            ->label('Site Description')
                            ->rows(3)
                            ->maxLength(500),
                    ])
                    ->columns(2),
                
                Section::make('Admin Panel Settings')
                    ->schema([
                        Select::make('admin_theme')
                            ->label('Admin Theme')
                            ->options([
                                'light' => 'Light Mode',
                                'dark' => 'Dark Mode',
                                'system' => 'System Preference',
                            ])
                            ->default('system')
                            ->helperText('Choose the default theme for the admin panel'),
                        
                        Toggle::make('enable_dark_mode')
                            ->label('Enable Dark Mode Toggle')
                            ->helperText('Allow users to toggle between light and dark modes')
                            ->default(true),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->action('save')
                ->color('primary'),
        ];
    }
    
    public function save(): void
    {
        $data = $this->form->getState();
        
        foreach ($data as $key => $value) {
            \App\Models\SiteSetting::set($key, $value);
        }
        
        Notification::make()
            ->title('Settings saved successfully!')
            ->success()
            ->send();
    }
}
