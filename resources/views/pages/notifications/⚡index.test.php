<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::notifications.index')
        ->assertStatus(200);
});
