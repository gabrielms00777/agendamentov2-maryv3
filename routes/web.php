<?php

use App\Http\Controllers\Auth\Logout;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Customer\Appointment\Index as AppointmentIndex;
use App\Livewire\Customer\Dashboard\Index as DashboardIndex;
use App\Livewire\Customer\Settings\Index as SettingsIndex;
use App\Livewire\Customer\Whatsapp\Index as WhatsappIndex;
use App\Livewire\Customer\Onboarding\Manager;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class);

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
 
Route::middleware('auth')->group(function () {
    Route::get('/logout', Logout::class)->name('logout');

    Route::get('/onboarding', Manager::class)->name('onboarding');

    Route::prefix('app')->group(function () {
        Route::get('/', DashboardIndex::class)->name('dashboard.index');
        Route::get('/agendamentos', AppointmentIndex::class)->name('appointments.index');
        Route::get('/settings', SettingsIndex::class)->name('settings.index');
        Route::get('/whatsapp', WhatsappIndex::class)->name('whatsapp.index');
    });


    // Route::get('/', 'index');
    // ... more
});
