<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::livewire('/roles', 'pages::roles.index' )->name('roles');
Route::livewire('/roles/create', 'pages::roles.create' )->name('roles.create');
Route::livewire('/role/{id}', 'pages::roles.edit' )->name('roles.edit');

Route::livewire('/users', 'pages::users.index' )->name('roles');
Route::livewire('/users/create', 'pages::users.create' )->name('roles.create');
Route::livewire('/user/{id}', 'pages::user.edit' )->name('roles.edit');


require __DIR__.'/settings.php';
