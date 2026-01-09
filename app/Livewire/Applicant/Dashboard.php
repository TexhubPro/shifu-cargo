<?php

namespace App\Livewire\Applicant;

use App\Models\Application;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Order;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.applicant')]
class Dashboard extends Component
{
    public function render()
    {
        $pendingCount = Application::where('status', 'В ожидании')->count();
        $readyCount = Application::where('status', 'В ожидании')
            ->whereNotNull('phone')->where('phone', '!=', '')
            ->whereNotNull('address')->where('address', '!=', '')
            ->count();

        $ordersToday = Order::whereDate('created_at', Carbon::today())->count();

        $chatsCount = Chat::count();
        $unreadMessages = Message::where('status', false)->count();

        $days = collect(range(6, 0))
            ->map(fn ($offset) => Carbon::now()->subDays($offset))
            ->values();

        $applicationsByDay = $days->map(function ($day) {
            return [
                'label' => $day->format('d.m'),
                'value' => Application::whereDate('created_at', $day->toDateString())->count(),
            ];
        });

        $ordersByDay = $days->map(function ($day) {
            return [
                'label' => $day->format('d.m'),
                'value' => Order::whereDate('created_at', $day->toDateString())->count(),
            ];
        });

        $maxApplications = max(1, (int) $applicationsByDay->max('value'));
        $maxOrders = max(1, (int) $ordersByDay->max('value'));

        $messagesByDay = $days->map(function ($day) {
            return [
                'label' => $day->format('d.m'),
                'value' => Message::whereDate('created_at', $day->toDateString())->count(),
            ];
        });
        $maxMessages = max(1, (int) $messagesByDay->max('value'));

        $recentApplications = Application::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $recentChats = Chat::with('user')
            ->withCount('unreadMessages')
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.applicant.dashboard', [
            'pendingCount' => $pendingCount,
            'readyCount' => $readyCount,
            'ordersToday' => $ordersToday,
            'chatsCount' => $chatsCount,
            'unreadMessages' => $unreadMessages,
            'applicationsByDay' => $applicationsByDay,
            'ordersByDay' => $ordersByDay,
            'maxApplications' => $maxApplications,
            'maxOrders' => $maxOrders,
            'messagesByDay' => $messagesByDay,
            'maxMessages' => $maxMessages,
            'recentApplications' => $recentApplications,
            'recentChats' => $recentChats,
        ]);
    }
}
