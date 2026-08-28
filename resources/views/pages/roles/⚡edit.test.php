<?php

use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

it('allows admin to view edit roles page', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::roles.edit', ['id' => $admin->roles->first()->id])
        ->assertStatus(200);
});

it('denies users without edit-roles permission from viewing roles', function () {

    $user = createUser();

    $role = createManagerRole();

    $this->actingAs($user);

    Livewire::test('pages::roles.edit', [
        'id' => $role->id,
    ])->assertForbidden();
});

it('denies guests to view edit role page', function () {

    $role = createManagerRole();

    $this->get(route('roles.edit', ['id' => $role->id]))
        ->assertRedirect('login');

});

it('allows admin to edit role', function () {

    $admin = createGeneralAdmin();

    $role = createManagerRole();

    $this->actingAs($admin);

    Livewire::test('pages::roles.edit', ['id' => $role->id])
        ->set('name', 'Manage Edited')
        ->call('updateRole', $role->id)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('roles', [
        'name' => 'Manage Edited',
    ]);
});

it('prevents duplicate roles', function () {
    $admin = createGeneralAdmin();

    $role = createManagerRole();

    $existingRole = Role::create([
        'name' => 'Users Manager',
        'guard_name' => 'web',
    ]);

    $this->actingAs($admin);

    Livewire::test('pages::roles.edit', [
        'id' => $role->id,
    ])
        ->set('name', $existingRole->name)
        ->call('updateRole',  $role->id)
        ->assertHasErrors('name');
});
