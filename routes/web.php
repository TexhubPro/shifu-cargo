<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Cashier;
use App\Http\Middleware\Manager as MiddlewareManager;
use App\Livewire\Admin\Applications;
use App\Livewire\Admin\Chats;
use App\Livewire\Admin\China;
use App\Livewire\Admin\Customers;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Dushanbe;
use App\Livewire\Admin\Emplyones;
use App\Livewire\Admin\Expences;
use App\Livewire\Admin\PAckages;
use App\Livewire\Admin\Settings as AdminSettings;
use App\Livewire\Admin\Smsbulk;
use App\Livewire\Admin\Trackcodes;
use App\Livewire\Chashdesk;
use App\Livewire\Components\SendNotification;
use App\Livewire\Deliver;
use App\Http\Middleware\Deliver as MidDeliver;
use App\Http\Controllers\CashdeskControlController;
use App\Livewire\Admin\Analitic;
use App\Livewire\Admin\Faqs as AdminFaqs;
use App\Livewire\Admin\Orders;
use App\Livewire\Admin\OrderShow;
use App\Livewire\Admin\RegisterPack;
use App\Livewire\Admin\Profile as AdminProfile;
use App\Livewire\Applicant;
use App\Livewire\Login;
use App\Livewire\Manager;
use App\Livewire\MiniApp\AddOrder;
use App\Livewire\MiniApp\AllOrders;
use App\Livewire\MiniApp\Application;
use App\Livewire\MiniApp\Calculator;
use App\Livewire\MiniApp\CheckOrder;
use App\Livewire\MiniApp\Faqs;
use App\Livewire\MiniApp\Notify;
use App\Livewire\MiniApp\Profile;
use App\Livewire\MiniApp\Queue;
use App\Livewire\MiniApp\Register;
use App\Livewire\MiniApp\Settings;
use App\Livewire\MiniApp\Support;
use App\Livewire\Queue as LivewireQueue;
use App\Livewire\QueueControl;
use App\Livewire\QueueKiosk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register/{id?}', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});
Route::get('/profile/{id?}', Profile::class)->name('profile');
Route::middleware('auth')->group(function () {
    Route::get('/all-orders', AllOrders::class)->name('all-orders');
    Route::get('/add-order', AddOrder::class)->name('add-order');
    Route::get('/check-order', CheckOrder::class)->name('check-order');
    Route::get('/application', Application::class)->name('application');
    Route::get('/queue', Queue::class)->name('queue');
    Route::get('/support', Support::class)->name('support');
    Route::get('/calculator', Calculator::class)->name('calculator');
    Route::get('/faqs', Faqs::class)->name('faqs');
    Route::get('/settings', Settings::class)->name('settings');
    Route::get('/notify', Notify::class)->name('notify');
    Route::get('/testqueue', SendNotification::class)->name('testqueue');
    Route::get('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});
Route::middleware(['auth', Admin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/china', China::class)->name('china');
    Route::get('/dushanbe', Dushanbe::class)->name('dushanbe');
    Route::get('/trackcodes', Trackcodes::class)->name('trackcodes');
    Route::get('/customers', Customers::class)->name('customers');
    Route::get('/applications', Applications::class)->name('applications');
    Route::get('/smsbulk', Smsbulk::class)->name('smsbulk');
    Route::get('/chats', Chats::class)->name('chats');
    Route::get('/packages', PAckages::class)->name('packages');
    Route::get('/emplyones', Emplyones::class)->name('emplyones');
    Route::get('/settings', AdminSettings::class)->name('settings');
    Route::get('/expences', Expences::class)->name('expences');
    Route::get('/faqs', AdminFaqs::class)->name('faqs');
    Route::get('/orders', Orders::class)->name('orders');
    Route::get('/orders/{order}', OrderShow::class)->name('orders.show');
    Route::get('/analitic', Analitic::class)->name('analitic');
    Route::get('/register-pack', RegisterPack::class)->name('register-pack');
    Route::get('/admin-profile', AdminProfile::class)->name('admin-profile');
});
Route::middleware(['auth', Cashier::class])->group(function () {
    // Route::get('/cashier', Chashdesk::class)->name('cashier');
    Route::get('/cashier/reports', \App\Livewire\CashdeskReports::class)->name('cashier.reports');
    Route::get('/queue-control', QueueControl::class)->name('queue-control');
    Route::get('/cashier', [CashdeskControlController::class, 'index'])->name('cashdesk-control');
    Route::post('/cashdesk-control/order', [CashdeskControlController::class, 'placeOrder'])->name('cashdesk-control.order');
    Route::post('/cashdesk-control/hold', [CashdeskControlController::class, 'holdOrder'])->name('cashdesk-control.hold');
    Route::get('/cashdesk-control/held/{heldOrder}', [CashdeskControlController::class, 'loadHeldOrder'])->name('cashdesk-control.held.load');
    Route::delete('/cashdesk-control/held/{heldOrder}', [CashdeskControlController::class, 'deleteHeldOrder'])->name('cashdesk-control.held.delete');
    Route::post('/cashdesk-control/queue/{queue}', [CashdeskControlController::class, 'selectQueue'])->name('cashdesk-control.queue.select');
    Route::post('/cashdesk-control/expense', [CashdeskControlController::class, 'addExpense'])->name('cashdesk-control.expense');
    Route::post('/cashdesk-control/currency', [CashdeskControlController::class, 'saveCurrency'])->name('cashdesk-control.currency');
});
Route::middleware(['auth', MiddlewareManager::class])->group(function () {
    Route::get('/manager', Manager::class)->name('manager');
});
Route::middleware(['auth', MidDeliver::class])->group(function () {
    Route::get('/deliver', Deliver::class)->name('deliver');
});
Route::middleware(['auth', MidDeliver::class])->group(function () {
    Route::get('/applicant', Applicant::class)->name('applicant');
});
Route::get('/navbat', LivewireQueue::class)->name('navbat');
Route::get('/queue-kiosk', QueueKiosk::class)->name('queue-kiosk');
