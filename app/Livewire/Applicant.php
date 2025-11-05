<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use Livewire\Component;
use App\Texhub\Telegram;
use App\Models\Trackcode;
use App\Models\Application;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;


#[Layout('components.layouts.empty')]
class Applicant extends Component
{
    use WithFileUploads;
    public $orders;
    public $selected_order;
    public $delivers;
    public $deliver_boy = 'Shod';
    public $delivery_price = 0;
    public $weight = 0;
    public $volume = 0;
    public $payment_type;
    public $discount = 0;
    public $tracks = []; // массив трек-кодов
    public $newTrack;
    public $discountt;
    public $total_amount = 0;
    public $discount_total = 0;
    public $total_final = 0;
    public $file;


    public function restart()
    {
        return redirect()->route('applicant');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
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
    public function select_order($id)
    {
        $this->selected_order = Application::find($id);
    }
    public function order_place()
    {
        if ($this->selected_order) {
            $apl = $this->selected_order;
            $apl->status = "Доставляется";
            $apl->save();
        }
        $user = User::find($this->selected_order->user_id);
        $deliver = User::where('name', str($this->deliver_boy))->first();
        $order = Order::create([
            'user_id' => $user->id,
            'weight' => $this->weight,
            'cube' => $this->volume,
            'subtotal' => $this->total_amount,
            'delivery_total' => $this->delivery_price,
            'deliver_id' => $deliver->id ?? $this->deliver_boy,
            'discount' => $this->discount_total,
            'total' => $this->total_final,
            'status' => "Доставляется",
        ]);
        if ($user) {
            if ($this->file) {

                // Сохраняем документ в папку storage/app/public/fotootchet
                $path = $this->file->store('fotootchet', 'public');

                // Формируем публичную ссылку
                $url = asset('storage/' . $path);
                $file = $url ?? null;
            }
            $sms = new Telegram();
            $sms->sms_order($user->id, $order->id, $file);
        }
        if ($deliver) {
            $sms_delivery = new Telegram();
            $sms_delivery->sms_deliver_boy($deliver->id, $order->id, $this->selected_order->id);
        }
        $this->updateTrackStatuses($user->id, $order->id);

        return redirect()->route('applicant');
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
        $this->orders = Application::orderBy('created_at', 'asc')->where('status', 'В ожидании')->get();
        $this->delivers = User::where('role', 'deliver')->get();
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
        if ($weight <= 10) {
            $kg_total = $weight * (float) $this->getKgPriceTJS();
        } elseif ($weight <= 20) {
            $kg_total = $weight *  (float) $this->getKgPrice10TJS();
        } elseif ($weight <= 30) {
            $kg_total = $weight * (float) $this->getKgPrice20TJS();
        } else {
            $kg_total = $weight * (float) $this->getKgPrice30TJS();
        }
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
    private function getKgPriceTJS()
    {
        $kg_price_usd = (float) str_replace('$', '', Setting::where('name', 'kg_price')->value('content'));
        $course = (float) Setting::where('name', 'course_dollar')->value('content');
        return $kg_price_usd * $course;
    }
    private function getKgPrice10TJS()
    {
        $kg_price_usd = (float) str_replace('$', '', Setting::where('name', 'kg_price_10')->value('content'));
        $course = (float) Setting::where('name', 'course_dollar')->value('content');
        return $kg_price_usd * $course;
    }
    private function getKgPrice20TJS()
    {
        $kg_price_usd = (float) str_replace('$', '', Setting::where('name', 'kg_price_20')->value('content'));
        $course = (float) Setting::where('name', 'course_dollar')->value('content');
        return $kg_price_usd * $course;
    }
    private function getKgPrice30TJS()
    {
        $kg_price_usd = (float) str_replace('$', '', Setting::where('name', 'kg_price_30')->value('content'));
        $course = (float) Setting::where('name', 'course_dollar')->value('content');
        return $kg_price_usd * $course;
    }
    private function getCubePriceTJS()
    {
        $cube_price_usd = (float) str_replace('$', '', Setting::where('name', 'cube_price')->value('content'));
        $course = (float) Setting::where('name', 'course_dollar')->value('content');
        return $cube_price_usd * $course;
    }
    public function cancel($id)
    {
        $apl = Application::find($id);
        $apl->status = "Отменено";
        $apl->save();
        return redirect()->route('applicant');
    }
    public function render()
    {
        return view('livewire.applicant');
    }
}
