<?php

namespace App\Livewire;

use Flux\Flux;
use App\Models\User;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Expences;
use App\Models\Order;
use App\Models\Queue;
use App\Models\Trackcode;
use App\Texhub\Telegram;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.empty')]
class Chashdesk extends Component
{
    public $user;
    public $queues;
    public $users;
    public $order_no;
    public $delivery_price = 0;
    public $weight = 0;
    public $volume = 0;
    public $payment_type = 'Наличными';
    public $total_amount;
    public $discount = 0;
    public $discount_total = 0;
    public $discountt = 'Фиксированная';
    public $total;
    public $total_final;
    public $client;
    public $amount;
    public $delivers;
    public $deliver_boy;
    public $tracks = []; // массив трек-кодов
    public $newTrack;    // ввод нового трека
    public $description;
    public $selected_queue;
    public function order_place()
    {
        $user = User::where('phone', $this->client)->first();
        $deliver = User::where('name', $this->deliver_boy)->first();
        $order = Order::create([
            'user_id' => $user->id ?? $this->client,
            'weight' => $this->weight,
            'cube' => $this->volume,
            'subtotal' => $this->total_amount,
            'delivery_total' => $this->delivery_price,
            'deliver_id' => $deliver->id ?? $this->deliver_boy,
            'discount' => $this->discount_total,
            'total' => $this->total_final,
        ]);
        if ($user) {
            $sms = new Telegram();
            $sms->sms_order($user->id, $order->id);
        }
        $this->updateTrackStatuses($user->id, $order->id);
        if ($this->selected_queue) {
            Queue::find($this->selected_queue)->delete();
        }
        return redirect()->route('cashier');
    }
    public function updateTrackStatuses($user_id, $order_id)
    {
        if (empty($this->tracks)) {
        } else {
            foreach ($this->tracks as $code) {
                $track = Trackcode::where('code', trim($code))->first();
                if ($track) {
                    $track->customer = Carbon::now();
                    $track->status = 'Получено';
                    $track->user_id = $user_id ?? $this->client;
                    $track->order_id = $order_id;
                    $track->save();
                } else {
                    Trackcode::create([
                        'code' => trim($code),
                        'china' => Carbon::now(),
                        'dushanbe' => Carbon::now(),
                        'customer' => Carbon::now(),
                        'status' => 'Получено',
                        'user_id' => $user_id ?? $this->client,
                        'order_id' => $order_id
                    ]);
                }
            }
        }
    }
    public function mount()
    {
        $this->queues = Queue::where('status', 'В очереди')->whereDate('created_at', Carbon::today())->get();
        $this->users = User::where('role', 'customer')->get();
        $this->delivers = User::where('role', 'deliver')->get();
        $this->total_amounts();
    }
    public function select_queues($id)
    {
        $queue = Queue::find($id);
        $queue->status = "Касса";
        $queue->save();
        $this->client = $queue->user->phone;
        $this->selected_queue = $queue->id;
        Flux::modals()->close();
    }
    public function updatedDiscount()
    {
        $this->total_amounts();
    }
    public function updatedDiscountt()
    {
        $this->total_amounts();
    }
    public function updatedWeight()
    {
        $this->total_amounts();
    }
    public function updatedVolume()
    {
        $this->total_amounts();
    }
    public function updatedDelivery_price()
    {
        $this->total_amounts();
    }
    public function total_amounts()
    {
        $weight = (float) ($this->weight ?? 0);
        $volume = (float) ($this->volume ?? 0);
        $kg_price = (float) $this->getKgPriceTJS();
        $cube_price = (float) $this->getCubePriceTJS();
        $discount = (float) ($this->discount ?? 0);

        // Расчёт стоимости
        $kg_total = $weight * $kg_price;
        $cube_total = $volume * $cube_price;

        // Общая сумма без скидки
        $this->total_amount = $kg_total + $cube_total;

        // Расчёт скидки
        $this->discount_total = 0;
        if ($discount > 0) {
            if ($this->discountt === 'Процентная' || $this->discountt === 'percent') {
                $this->discount_total = $this->total_amount * ($discount / 100);
            } else {
                $this->discount_total = $discount;
            }
        }
        $this->total_final = max(0, $this->total_amount - $this->discount_total + $this->delivery_price);
    }

    public function addTrack()
    {
        $track = trim($this->newTrack);

        if ($track && !in_array($track, $this->tracks)) {
            $this->tracks[] = $track;
        }
        $this->newTrack = '';
    }

    public function removeTrack($index)
    {
        unset($this->tracks[$index]);
        $this->tracks = array_values($this->tracks);
    }
    public function addExpense()
    {

        Expences::create([
            'sklad' => 'Склад Душанбе',
            'total' => $this->amount,
            'content' => $this->description,
        ]);

        $this->reset(['amount', 'description']);
        Flux::modals()->close();
        $this->dispatch('alert', 'Затраты успешно добавлены!');
    }
    private function getKgPriceTJS()
    {
        $kg_price_usd = (float) str_replace('$', '', Setting::where('name', 'kg_price')->value('content'));
        $course = (float) Setting::where('name', 'course_dollar')->value('content');
        return $kg_price_usd * $course;
    }

    private function getCubePriceTJS()
    {
        $cube_price_usd = (float) str_replace('$', '', Setting::where('name', 'cube_price')->value('content'));
        $course = (float) Setting::where('name', 'course_dollar')->value('content');
        return $cube_price_usd * $course;
    }
    public function render()
    {
        return view('livewire.chashdesk');
    }
}
