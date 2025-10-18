<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class PromoteToOwner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:promote-to-owner 
                            {identifier : The email or username of the user to promote}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote an existing user to owner role with full access';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $identifier = $this->argument('identifier');
        
        $this->info('🔍 Looking for user: ' . $identifier);

        // Try to find user by email or username
        $user = User::where('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();

        if (!$user) {
            $this->error('❌ User not found with email or username: ' . $identifier);
            return self::FAILURE;
        }

        // Check if owner role exists
        $ownerRole = Role::where('name', 'owner')->first();
        
        if (!$ownerRole) {
            $this->warn('⚠️  Owner role not found. Running seeder...');
            $this->call('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
            $ownerRole = Role::where('name', 'owner')->first();
            
            if (!$ownerRole) {
                $this->error('❌ Failed to create owner role.');
                return self::FAILURE;
            }
        }

        // Check if user already has owner role
        if ($user->hasRole('owner')) {
            $this->warn('⚠️  User already has the owner role.');
            $this->displayUserInfo($user);
            return self::SUCCESS;
        }

        // Display user info and ask for confirmation
        $this->newLine();
        $this->table(
            ['Field', 'Value'],
            [
                ['ID', $user->id],
                ['Name', $user->name],
                ['Username', $user->username],
                ['Email', $user->email],
                ['Current Roles', $user->roles->pluck('name')->join(', ') ?: 'None'],
            ]
        );
        
        $this->newLine();
        if (!$this->confirm('Promote this user to Owner with full admin and website access?', true)) {
            $this->info('Operation cancelled.');
            return self::SUCCESS;
        }

        try {
            // Remove existing admin roles to avoid conflicts
            $adminRoles = ['SuperAdmin', 'Moderator', 'Finance', 'Support', 'Content'];
            foreach ($adminRoles as $role) {
                if ($user->hasRole($role)) {
                    $user->removeRole($role);
                }
            }

            // Assign owner role
            $user->assignRole('owner');
            
            // Ensure user is verified and active
            $user->update([
                'is_verified' => true,
                'is_active' => true,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);

            $this->newLine();
            $this->info('✅ User promoted to owner successfully!');
            $this->newLine();
            
            $this->displayUserInfo($user->fresh());
            
            return self::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('❌ Failed to promote user: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Display user information
     */
    private function displayUserInfo(User $user): void
    {
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
                ['Verified', $user->is_verified ? '✓ Yes' : '✗ No'],
                ['Active', $user->is_active ? '✓ Yes' : '✗ No'],
            ]
        );
        
        $this->newLine();
        $this->info('📝 Access Details:');
        $this->line('   Admin Panel: ' . config('app.url') . '/admin');
        $this->line('   Website: ' . config('app.url'));
        $this->newLine();
    }
}


