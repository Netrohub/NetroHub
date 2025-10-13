<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:admin
                            {email? : Admin email address}
                            {--username= : Admin username}
                            {--password= : Admin password}
                            {--name= : Admin name}
                            {--owner : Assign owner role (highest level)}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new admin or owner account';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔧 NetroHub Admin Account Creator');
        $this->newLine();

        // Get or prompt for details
        $email = $this->argument('email') ?: $this->ask('Email address', 'admin@netrohub.com');
        $username = $this->option('username') ?: $this->ask('Username', 'admin');
        $name = $this->option('name') ?: $this->ask('Name', 'Administrator');
        $password = $this->option('password') ?: $this->secret('Password (leave empty for auto-generated)');
        $isOwner = $this->option('owner') ?: $this->confirm('Assign owner role? (highest access level)', false);

        // Generate password if not provided
        if (empty($password)) {
            $password = Str::random(16);
            $generatedPassword = true;
        } else {
            $generatedPassword = false;
        }

        // Validate username
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
            $this->error('Username can only contain letters, numbers, underscores, and hyphens.');
            return self::FAILURE;
        }

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists!');
            
            if ($this->confirm('Update existing user?', false)) {
                $user = User::where('email', $email)->first();
                $this->info('Updating existing user...');
            } else {
                return self::FAILURE;
            }
        } else {
            // Create new user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $this->info('✅ User created successfully!');
        }

        // Assign roles
        if ($isOwner) {
            $user->syncRoles(['owner', 'admin']);
            $this->info('✅ Owner and Admin roles assigned');
        } else {
            $user->syncRoles(['admin']);
            $this->info('✅ Admin role assigned');
        }

        // Display credentials
        $this->newLine();
        $this->info('═══════════════════════════════════════════════════════════');
        $this->info('           ADMIN ACCOUNT CREDENTIALS');
        $this->info('═══════════════════════════════════════════════════════════');
        $this->newLine();
        $this->line('  Name:     ' . $name);
        $this->line('  Email:    ' . $email);
        $this->line('  Username: ' . $username);
        
        if ($generatedPassword) {
            $this->line('  Password: ' . $password);
            $this->newLine();
            $this->warn('⚠️  IMPORTANT: Save this password securely!');
            $this->warn('⚠️  You cannot retrieve it later.');
        } else {
            $this->line('  Password: (as provided)');
        }

        $this->newLine();
        $this->line('  Role:     ' . ($isOwner ? 'Owner (Full Access)' : 'Admin'));
        $this->line('  Panel:    ' . config('app.url') . '/admin');
        $this->newLine();
        $this->info('═══════════════════════════════════════════════════════════');
        $this->newLine();

        return self::SUCCESS;
    }
}

