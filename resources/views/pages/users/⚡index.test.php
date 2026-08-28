<?php

use Livewire\Livewire;

it('allows authorised users to view users', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::users.index')
        ->assertStatus(200);
});

it('denies unauthorised users to view users', function () {

    $user = createUser();

    $this->actingAs($user);

    Livewire::test('pages::users.index')
        ->assertForbidden();
});

it('denies general users to see admin user record', function () {

    $user = createUser();
    $admin = createGeneralAdmin();

    $this->actingAs($user);

    Livewire::test('pages::users.index')
        ->assertDontSee($admin->name);

});

it('allows general admin to see admin user records', function () {

    $user = createUser();
    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::users.index')
        ->assertSee($admin->name);

});
