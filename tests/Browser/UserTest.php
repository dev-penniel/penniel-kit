<?php

use Livewire\Livewire;
use Pest\Laravel\visit;

it('can view users page', function (){

    
        $email = 'admin@example.com';
        $password = '123456789';
    

    visit('http://penniel-kit.test/login')
    ->type('email', $email)
    ->type('password', $password)
    ->click('Log in')
    ->assertSee('Welcome');

});
