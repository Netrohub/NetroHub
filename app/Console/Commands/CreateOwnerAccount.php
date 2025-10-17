<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class CreateOwnerAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-owner 
                            {--email= : The email address of the owner}
                            {--name= : The name of the owner}
                            {--username= : The username of the owner}
                            {--password= : The password for the owner account}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new owner account with full admin and website access';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Creating Owner Account');
        $this->info('Owner accounts have full access to both the admin panel and website.');
        $this->newLine();

        // Get email
        $email = $this->option('email') ?: $this->ask('Email address');
        
        // Validate email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            $this->error('❌ ' . $validator->errors()->first('email'));
            return self::FAILURE;
        }

        // Get name
        $name = $this->option('name') ?: $this->ask('Full name');

        // Get username
        $username = $this->option('username') ?: $this->ask('Username');
        
        // Validate username
        $validator = Validator::make(['username' => $username], [
            'username' => 'required|string|min:3|max:50|unique:users,username|regex:/^[a-zA-Z0-9_-]+$/',
        ]);

        if ($validator->fails()) {
            $this->error('❌ ' . $validator->errors()->first('username'));
            return self::FAILURE;
        }

        // Get password
        $password = $this->option('password') ?: $this->secret('Password (min 8 characters)');
        
        if (strlen($password) < 8) {
            $this->error('❌ Password must be at least 8 characters long.');
            return self::FAILURE;
        }

        // Confirm password if not provided via option
        if (!$this->option('password')) {
            $passwordConfirm = $this->secret('Confirm password');
            
            if ($password !== $passwordConfirm) {
                $this->error('❌ Passwords do not match.');
                return self::FAILURE;
            }
        }

        // Check if owner role exists
        $ownerRole = Role::where('name', 'owner')->first();
        
        if (!$ownerRole) {
            $this->warn('⚠️  Owner role not found. Please run: php artisan db:seed --class=RolesAndPermissionsSeeder');
            
            if ($this->confirm('Would you like to create the owner role now?', true)) {
                $this->call('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
                $ownerRole = Role::where('name', 'owner')->first();
            }
            
            if (!$ownerRole) {
                $this->error('❌ Failed to create owner role.');
                return self::FAILURE;
            }
        }

        // Create the user
        try {
            $user = User::create([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'is_verified' => true,
                'is_active' => true,
            ]);

            // Assign owner role
            $user->assignRole('owner');

            $this->newLine();
            $this->info('✅ Owner account created successfully!');
            $this->newLine();
            
            $this->table(
                ['Field', 'Value'],
                [
                    ['ID', $user->id],
                    ['Name', $user->name],
                    ['Username', $user->username],
                    ['Email', $user->email],
                    ['Role', 'owner'],
                    ['Admin Access', '✓ Yes'],
                    ['Website Access', '✓ Yes'],
                ]
            );

            $this->newLine();
            $this->info('📝 Access Details:');
            $this->line('   Admin Panel: ' . config('app.url') . '/admin');
            $this->line('   Website: ' . config('app.url'));
            $this->newLine();
            
            return self::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('❌ Failed to create owner account: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}

