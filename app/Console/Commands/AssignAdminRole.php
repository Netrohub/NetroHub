<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignAdminRole extends Command
{
    protected $signature = 'admin:assign-role {email}';
    
    protected $description = 'Assign SuperAdmin role to a user';

    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }
        
        $superAdminRole = Role::where('name', 'SuperAdmin')->first();
        
        if (!$superAdminRole) {
            $this->error("SuperAdmin role not found! Run the RolesAndPermissionsSeeder first.");
            return 1;
        }
        
        // Remove any existing roles and assign SuperAdmin
        $user->syncRoles(['SuperAdmin']);
        
        $this->info("✅ SuperAdmin role assigned to {$user->name} ({$user->email})");
        $this->info("User can now access the admin panel at /admin");
        
        return 0;
    }
}

