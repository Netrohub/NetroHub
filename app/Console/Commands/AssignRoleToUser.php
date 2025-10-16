<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AssignRoleToUser extends Command
{
    protected $signature = 'user:assign-role {email} {role}';
    protected $description = 'Assign a role to a user by email';

    public function handle(): int
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ User with email '{$email}' not found!");
            return self::FAILURE;
        }

        $user->assignRole($role);
        
        $this->info("✅ Role '{$role}' assigned to user '{$email}'");
        
        return self::SUCCESS;
    }
}

