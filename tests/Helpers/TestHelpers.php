<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

function createUser(): User
{
    return User::factory()->create();
}
function createGeneralAdmin(): User
{
    $permissionNames = [
        'access-users',
        'create-users',
        'edit-users',
        'delete-users',
    ];

    $permissions = collect();

    foreach ($permissionNames as $name) {
        $permissions->push(
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ])
        );
    }

    $role = Role::firstOrCreate([
        'name' => 'General Admin',
        'guard_name' => 'web',
    ]);

    $role->givePermissionTo($permissions);

    $user = User::factory()->create();

    $user->assignRole($role);

    return $user;
}
