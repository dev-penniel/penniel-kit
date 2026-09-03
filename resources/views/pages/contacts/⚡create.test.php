<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::contacts.create')
        ->assertStatus(200);
});
