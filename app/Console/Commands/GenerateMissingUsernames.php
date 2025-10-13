<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateMissingUsernames extends Command
{
    protected $signature = 'users:generate-usernames';
    
    protected $description = 'Generate usernames for users who don\'t have one';

    public function handle()
    {
        $usersWithoutUsername = User::whereNull('username')
            ->orWhere('username', '')
            ->get();

        if ($usersWithoutUsername->isEmpty()) {
            $this->info('✅ All users have usernames!');
            return 0;
        }

        $this->info("Found {$usersWithoutUsername->count()} user(s) without username. Generating...");

        foreach ($usersWithoutUsername as $user) {
            $username = $this->generateUniqueUsername($user->name ?? $user->email);
            
            $user->update(['username' => $username]);
            
            $this->line("✓ User #{$user->id} ({$user->name}): @{$username}");
        }

        $this->newLine();
        $this->info('✅ All usernames generated successfully!');

        return 0;
    }

    protected function generateUniqueUsername(string $name): string
    {
        $baseUsername = Str::slug($name, '_');
        $baseUsername = preg_replace('/[^a-zA-Z0-9_]/', '', $baseUsername);
        $baseUsername = substr($baseUsername, 0, 20);
        
        // Fallback to random if empty
        if (empty($baseUsername)) {
            $baseUsername = 'user_' . Str::random(8);
        }

        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}

