<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class SetupRoles extends Command
{
    protected $signature = 'setup:roles';
    protected $description = 'Create all necessary roles for the application';

    public function handle(): int
    {
        $this->info('🔧 Creating roles...');

        // Create roles
        $roles = ['admin', 'owner', 'user', 'seller'];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);
            $this->info("✅ Role '{$roleName}' created/verified");
        }

        $this->newLine();
        $this->info('✅ All roles created successfully!');
        
        return self::SUCCESS;
    }
}

