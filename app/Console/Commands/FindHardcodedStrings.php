<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FindHardcodedStrings extends Command
{
    protected $signature = 'translations:find-hardcoded {file?}';
    protected $description = 'Find hardcoded English strings in blade files';

    public function handle()
    {
        $file = $this->argument('file');
        
        if ($file) {
            $this->scanFile($file);
        } else {
            $this->scanDirectory();
        }
        
        return Command::SUCCESS;
    }

    protected function scanDirectory()
    {
        $this->info('🔍 Scanning views for hardcoded strings...');
        $this->newLine();
        
        $viewsPath = resource_path('views');
        $files = File::allFiles($viewsPath);
        
        $stats = [
            'total_files' => 0,
            'files_with_hardcoded' => 0,
            'total_strings' => 0,
        ];
        
        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            
            $stats['total_files']++;
            $relativePath = str_replace($viewsPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
            
            $strings = $this->findHardcodedInFile($file->getPathname());
            
            if (count($strings) > 0) {
                $stats['files_with_hardcoded']++;
                $stats['total_strings'] += count($strings);
                
                $this->warn("📄 {$relativePath}");
                $this->line("   Found " . count($strings) . " hardcoded strings");
                
                // Show first 3 examples
                foreach (array_slice($strings, 0, 3) as $string) {
                    $this->line("   → \"{$string}\"");
                }
                
                if (count($strings) > 3) {
                    $this->line("   ... and " . (count($strings) - 3) . " more");
                }
                
                $this->newLine();
            }
        }
        
        $this->info('📊 Summary:');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total blade files', $stats['total_files']],
                ['Files with hardcoded text', $stats['files_with_hardcoded']],
                ['Files already translated', $stats['total_files'] - $stats['files_with_hardcoded']],
                ['Total hardcoded strings found', $stats['total_strings']],
            ]
        );
        
        if ($stats['files_with_hardcoded'] > 0) {
            $this->newLine();
            $this->comment('💡 To see details for a specific file:');
            $this->comment('   php artisan translations:find-hardcoded "auth/login.blade.php"');
        }
    }

    protected function scanFile($filename)
    {
        $viewsPath = resource_path('views');
        $filePath = $viewsPath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $filename);
        
        if (!File::exists($filePath)) {
            $this->error("❌ File not found: {$filename}");
            return;
        }
        
        $this->info("🔍 Scanning: {$filename}");
        $this->newLine();
        
        $content = File::get($filePath);
        $lines = explode("\n", $content);
        
        foreach ($lines as $lineNumber => $line) {
            // Skip lines that already use __()
            if (str_contains($line, '__(' ) || str_contains($line, '__(\'') || str_contains($line, '__("')) {
                continue;
            }
            
            // Look for text between > and <
            if (preg_match_all('/>([A-Z][a-zA-Z\s,\.!?\'"]{3,50})</i', $line, $matches)) {
                foreach ($matches[1] as $match) {
                    $match = trim($match);
                    if ($this->isLikelyEnglishText($match)) {
                        $this->line(sprintf("Line %d: \"%s\"", $lineNumber + 1, $match));
                    }
                }
            }
        }
    }

    protected function findHardcodedInFile($filePath)
    {
        $content = File::get($filePath);
        $strings = [];
        
        // Pattern 1: Text between > and < tags
        if (preg_match_all('/>([A-Z][a-zA-Z\s,\.!?\'"]{3,50})</', $content, $matches)) {
            foreach ($matches[1] as $match) {
                $match = trim($match);
                if ($this->isLikelyEnglishText($match) && !str_contains($content, "__('" . $match . "')")) {
                    $strings[] = $match;
                }
            }
        }
        
        return array_unique($strings);
    }

    protected function isLikelyEnglishText($text)
    {
        // Filter out code, variables, and non-text content
        if (str_contains($text, '{{') || str_contains($text, '}}')) {
            return false;
        }
        
        if (str_contains($text, '$') || str_contains($text, '@')) {
            return false;
        }
        
        if (preg_match('/^\d+$/', $text)) {
            return false;
        }
        
        // Must have at least one letter
        if (!preg_match('/[a-zA-Z]/', $text)) {
            return false;
        }
        
        return true;
    }
}

