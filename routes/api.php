<?php

use App\Http\Controllers\Api\Cashdesk\AuthController;
use App\Http\Controllers\Api\Cashdesk\CashdeskControlController;
use Illuminate\Support\Facades\Route;

Route::prefix('cashdesk')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login'])->name('api.cashdesk.auth.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me'])->name('api.cashdesk.auth.me');
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('api.cashdesk.auth.logout');
        Route::get('/control/meta', [CashdeskControlController::class, 'meta'])->name('api.cashdesk.control.meta');
        Route::get('/control/users', [CashdeskControlController::class, 'users'])->name('api.cashdesk.control.users');
        Route::get('/control/reports/today', [CashdeskControlController::class, 'todayReport'])->name('api.cashdesk.control.reports.today');
        Route::get('/control/reports/today/download', [CashdeskControlController::class, 'downloadTodayReport'])->name('api.cashdesk.control.reports.today.download');
        Route::post('/control/currency', [CashdeskControlController::class, 'saveCurrency'])->name('api.cashdesk.control.currency');
        Route::post('/control/expense', [CashdeskControlController::class, 'addExpense'])->name('api.cashdesk.control.expense');
        Route::post('/control/hold', [CashdeskControlController::class, 'holdOrder'])->name('api.cashdesk.control.hold');
        Route::post('/control/order', [CashdeskControlController::class, 'placeOrder'])->name('api.cashdesk.control.order');
    });
});
