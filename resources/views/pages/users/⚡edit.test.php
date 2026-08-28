<?php

use App\Models\User;
use Livewire\Livewire;

it('allows admin to view edit users page', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::users.edit', ['id' => $admin->id,])
        ->assertStatus(200);
});

it('denies users without edit-users permission from viewing users', function () {

    $user = createUser();

    $this->actingAs($user);

    Livewire::test('pages::users.edit', ['id' => $user->id,])
        ->assertForbidden();
});

it('denies guests to view edit users page', function () {

    $this->get(route('users'))
        ->assertRedirect('login');

});

it('allows admin to edit a user', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::users.edit', ['id' => $admin->id,])
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->set('selectedRole', 'General Admin')
        ->call('updateUser', $admin->id)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

it('prevents duplicate email addresses', function () {
    $admin = createGeneralAdmin();

    User::factory()->create([
        'email' => 'john@example.com',
    ]);

    $this->actingAs($admin);

    Livewire::test('pages::users.edit', [
        'id' => $admin->id,
    ])
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->call('updateUser',  $admin->id)
        ->assertHasErrors(['email']);
});
