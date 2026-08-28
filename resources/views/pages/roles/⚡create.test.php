<?php

use Livewire\Livewire;
use App\Models\User;
use Spatie\Permission\Models\Role;


it('allows admin to view create roles page', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::roles.create')
        ->assertStatus(200);
});

it('denies users without access-roles permission from viewing roles', function () {
    $user = createUser();

    $this->actingAs($user)
        ->get(route('roles'))
        ->assertForbidden();
});

it('denies guests to view roles page', function () {

    $this->get(route('roles'))
        ->assertRedirect('login');

});

it('allows admin to create a role', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::roles.create')
        ->set('name', 'Manager')
        ->call('createRole')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('roles', [
        'name' => 'Manager',
    ]);
});

it('requires valid information', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::roles.create')
        ->call('createRole')
        ->assertHasErrors();
});

it('prevents duplicate role', function () {

    $admin = createGeneralAdmin();

    Role::create([
        'name' => 'Manager',
        'guard_name' => 'web',
    ]);

    $this->actingAs($admin);

    Livewire::test('pages::roles.create')
        ->set('name', 'Manager')
        ->call('createRole')
        ->assertHasErrors(['name']);
});
