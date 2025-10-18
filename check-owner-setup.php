<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== OWNER ACCOUNT DIAGNOSTIC ===\n\n";

// Check if roles table exists
try {
    $roles = \Spatie\Permission\Models\Role::pluck('name')->toArray();
    echo "✅ Roles table exists\n";
    echo "Available roles: " . implode(', ', $roles) . "\n\n";
    
    // Check if owner role exists
    $ownerRole = \Spatie\Permission\Models\Role::where('name', 'owner')->first();
    if ($ownerRole) {
        echo "✅ Owner role exists (ID: {$ownerRole->id})\n";
        $permissionCount = $ownerRole->permissions()->count();
        echo "   Permissions: {$permissionCount}\n\n";
    } else {
        echo "❌ Owner role DOES NOT exist!\n";
        echo "   Run: php artisan db:seed --class=RolesAndPermissionsSeeder\n\n";
    }
} catch (Exception $e) {
    echo "❌ Error checking roles: " . $e->getMessage() . "\n\n";
}

// Check for users with owner role
try {
    $owners = \App\Models\User::role('owner')->get();
    echo "Owner accounts found: " . $owners->count() . "\n";
    
    if ($owners->count() > 0) {
        foreach ($owners as $owner) {
            echo "  - {$owner->name} ({$owner->email}) - ID: {$owner->id}\n";
        }
    } else {
        echo "  No owner accounts exist yet.\n";
        echo "  Create one with: php artisan user:create-owner\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "❌ Error checking users: " . $e->getMessage() . "\n\n";
}

// Check if CreateOwnerAccount command exists
$commandPath = __DIR__ . '/app/Console/Commands/CreateOwnerAccount.php';
if (file_exists($commandPath)) {
    echo "✅ CreateOwnerAccount command exists\n";
} else {
    echo "❌ CreateOwnerAccount command missing\n";
}

echo "\n=== NEXT STEPS ===\n";
echo "1. If owner role doesn't exist: php artisan db:seed --class=RolesAndPermissionsSeeder\n";
echo "2. Create owner account: php artisan user:create-owner\n";
echo "3. Clear cache: php artisan optimize:clear\n";
echo "4. Try accessing /admin again\n";


