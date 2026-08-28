<?php

use App\Models\User;
use Livewire\Livewire;

it('allows admin to view create users page', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::users.create')
            ->assertStatus(200);
});

it('denies users without access-users permission from viewing users', function () {
    $user = createUser();

    $this->actingAs($user)
        ->get(route('users'))
        ->assertForbidden();
});

it('denies guests to view users page', function () {

    $this->get(route('users'))
        ->assertRedirect('login');

});

it('allows admin to create a user', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::users.create')
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->set('selectedRole', 'General Admin')
        ->call('createUser')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

it('requires valid information', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::users.create')
        ->call('createUser')
        ->assertHasErrors();
});

it('prevents duplicate email addresses', function () {
    $admin = createGeneralAdmin();

    User::factory()->create([
        'email' => 'john@example.com',
    ]);

    $this->actingAs($admin);

    Livewire::test('pages::users.create')
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('createUser')
        ->assertHasErrors(['email']);
});
