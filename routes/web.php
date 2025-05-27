<?php

use App\Http\Controllers\Auth\Logout;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Customer\Onboarding;
use App\Livewire\Customer\Onboarding\Index;
use App\Livewire\Customer\Onboarding\Manager;
use App\Livewire\Customer\Onboarding\Teste;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class);

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
 
Route::middleware('auth')->group(function () {
    Route::get('/logout', Logout::class)->name('logout');

    Route::get('/onboarding', Manager::class)->name('onboarding');

    // Route::get('/', 'index');
    // ... more
});
