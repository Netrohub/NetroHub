<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportTranslations extends Command
{
    protected $signature = 'translations:import';
    protected $description = 'Import translations from JSON files to database';

    public function handle()
    {
        $this->info('Importing translations from JSON files...');
        
        Translation::importFromFiles();
        
        $count = Translation::count();
        $this->info("✓ Successfully imported {$count} translations!");
        
        return Command::SUCCESS;
    }
}
