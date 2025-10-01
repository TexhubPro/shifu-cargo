<?php

use App\Livewire\MiniApp\Profile;
use App\Livewire\MiniApp\Register;
use Illuminate\Support\Facades\Route;

Route::get('/profile/{id?}', Profile::class)->name('profile');
Route::get('/register/{id?}', Register::class)->name('register');
