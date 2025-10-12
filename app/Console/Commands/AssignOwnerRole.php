<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AssignOwnerRole extends Command
{
    protected $signature = 'admin:assign-owner {email}';

    protected $description = 'Assign owner role to a user';

    public function handle()
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("User with email {$email} not found.");

            return 1;
        }

        $user->assignRole('owner');
        $this->info("Owner role assigned to {$user->name} ({$user->email})");

        return 0;
    }
}
