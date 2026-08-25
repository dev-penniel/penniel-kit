<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::livewire('/roles', 'pages::roles.index' )->name('roles');
Route::livewire('/roles/create', 'pages::roles.create' )->name('roles.create');
Route::livewire('/role/{id}', 'pages::roles.edit' )->name('roles.edit');

Route::livewire('/users', 'pages::users.index' )->name('users')->middleware('role:access-users');
Route::livewire('/users/create', 'pages::users.create' )->name('users.create')->middleware('role:create-users');
Route::livewire('/user/{id}', 'pages::users.edit' )->name('user.edit')->middleware('role:edit-users');


require __DIR__.'/settings.php';
