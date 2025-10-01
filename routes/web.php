<?php

use App\Livewire\MiniApp\Profile;
use App\Livewire\MiniApp\Register;
use Illuminate\Support\Facades\Route;

Route::get('/profile/{id?}', Profile::class);
Route::get('/register', Register::class)->name('register');
