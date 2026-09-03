<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::contacts.edit')
        ->assertStatus(200);
});
