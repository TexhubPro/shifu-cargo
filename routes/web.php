<?php

use App\Livewire\MiniApp\AddOrder;
use App\Livewire\MiniApp\AllOrders;
use App\Livewire\MiniApp\Application;
use App\Livewire\MiniApp\Calculator;
use App\Livewire\MiniApp\CheckOrder;
use App\Livewire\MiniApp\Faqs;
use App\Livewire\MiniApp\Profile;
use App\Livewire\MiniApp\Queue;
use App\Livewire\MiniApp\Register;
use App\Livewire\MiniApp\Settings;
use App\Livewire\MiniApp\Support;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register/{id?}', Register::class)->name('register');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile/{id?}', Profile::class)->name('profile');
    Route::get('/all-orders', AllOrders::class)->name('all-orders');
    Route::get('/add-order', AddOrder::class)->name('add-order');
    Route::get('/check-order', CheckOrder::class)->name('check-order');
    Route::get('/application', Application::class)->name('application');
    Route::get('/queue', Queue::class)->name('queue');
    Route::get('/support', Support::class)->name('support');
    Route::get('/calculator', Calculator::class)->name('calculator');
    Route::get('/faqs', Faqs::class)->name('faqs');
    Route::get('/settings', Settings::class)->name('settings');
});
