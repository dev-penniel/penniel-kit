<?php

use Livewire\Livewire;

it('allows authorised users to view roles', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::roles.index')
        ->assertStatus(200);
});

it('denies unauthorised users to view roles', function () {

    $user = createUser();

    $this->actingAs($user);

    Livewire::test('pages::roles.index')
        ->assertForbidden();

});

it('denies general users to see admin roles record', function () {

    $user = createUser();
    $admin = createGeneralAdmin();

    $this->actingAs($user);

    Livewire::test('pages::roles.index')
        ->assertDontSee('General Admin');

});

it('allows general admin to see admin roles records', function () {

    $admin = createGeneralAdmin();

    $this->actingAs($admin);

    Livewire::test('pages::roles.index')
        ->assertSee('General Admin');

});

