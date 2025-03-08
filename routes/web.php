<?php

use App\Http\Controllers\DropoffLocationController;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdoptionsController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\SponsorshipsController;

Route::get('/', [HomeController::class, 'show'])->name('home');


Route::view('/sobre', 'pages.about.index')->name('about');
Route::view('/contato', 'pages.contact.index')->name('contact');
Route::view('/sobre', 'pages.about.index')->name('about');
Route::view('/apoie', 'pages.support.index')->name('support');
Route::view('/doe', 'pages.donate.index')->name('donation');
Route::view('/doe-itens-dia-a-dia', 'pages.needed-items.index')->name('needed-items');
Route::view('/doe-para-o-brecho', 'pages.thrift-store.index')->name('thrift-store');
Route::view('/ofereca-lar-temporario', 'pages.temporary-shelter.index')->name('temporary-shelter');
Route::get('/pontos-de-coleta', [DropoffLocationController::class, 'index'])->name('donation-dropoff');
Route::view('/politica-de-privacidade', 'pages.privacy-policy.index')->name('privacy-policy');
Route::view('/termos-de-uso', 'pages.terms-of-use.index')->name('terms-of-use');

Route::get('/adote', [AdoptionsController::class, 'index'])->name('adoption.index');
Route::get('/adote/{slug}', [AdoptionsController::class, 'create'])->name('adoption.create');

Route::get('/apadrinhe', [SponsorshipsController::class, 'index'])->name('sponsorship.index');
Route::get('/apadrinhe/{slug}', [SponsorshipsController::class, 'create'])->name('sponsorship.create');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
