<?php

namespace App\Livewire;

use App\Http\Controllers\SmsController;
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
use Livewire\WithPagination;


#[Layout('components.layouts.empty')]
class Applicant extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $perPage = 50;
    protected $paginationTheme = 'tailwind';
    public $selected_order;
    public $delivers;
    public $deliver_boy = 'Shod';
    public $delivery_price = 0;
    public $weight = 0;
    public $volume = 0;
    public $payment_type;
    public $discount = 0;
    public $discountt = 'Фиксированная';
    public $tracks = []; // массив трек-кодов
    public $newTrack;
    public $total_amount = 0;
    public $discount_total = 0;
    public $total_final = 0;
    public $file;
    public $trackLookupCode;
    public $trackLookupResult;
    public $trackLookupMessage = null;
    public $trackLookupState = 'info';


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
    public function lookupTrack(): void
    {
        $code = trim($this->trackLookupCode ?? '');
        $this->trackLookupResult = null;
        $this->trackLookupMessage = null;
        $this->trackLookupState = 'info';

        if ($code === '') {
            $this->trackLookupMessage = 'Введите трек-код для проверки.';
            $this->trackLookupState = 'warning';
            return;
        }

        $track = Trackcode::where('code', $code)->first();
        if ($track) {
            $this->trackLookupResult = [
                'code' => $track->code,
                'status' => $track->status,
                'china' => optional($track->china)->format('d.m.Y H:i'),
                'dushanbe' => optional($track->dushanbe)->format('d.m.Y H:i'),
                'customer' => optional($track->customer)->format('d.m.Y H:i'),
            ];
            $this->trackLookupMessage = 'Статус успешно найден.';
            $this->trackLookupState = 'success';
        } else {
            $this->trackLookupMessage = 'Трек-код не найден.';
            $this->trackLookupState = 'danger';
        }
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
        $photoPath = null;
        $photoUrl = null;

        if ($this->file) {
            $photoPath = $this->file->store('fotootchet', 'public');
            $photoUrl = '/storage/' . $photoPath;
        }
        $order = Order::create([
            'user_id' => $user->id,
            'application_id' => $apl->id ?? null,
            'weight' => $this->weight,
            'cube' => $this->volume,
            'subtotal' => $this->total_amount,
            'delivery_total' => $this->delivery_price,
            'deliver_id' => $deliver->id ?? $this->deliver_boy,
            'discount' => $this->discount_total,
            'total' => $this->total_final,
            'status' => "Доставляется",
            'photo_report_path' => $photoPath,
        ]);

        if ($user) {
            $sms = new Telegram();
            $sms->sms_order($user->id, $order->id, $photoUrl);
        }

        $message = "📦 Салом, муштарии муҳтарам!\n\n🚚 Шумо бо муваффақият фармоиши худро қабул/дархост намудед.\n⚖️ Вазн: $order->weight кг\n📏 Ҳаҷм: $order->cube м³\n💰 Ҷамъбаст: $order->subtotal с\n💵 Тахфиф: $order->discount с\n🚛 Нархи бурда расонӣ: $order->delivery_total с\n✅ Ҳамагӣ: $order->total с\n\nТашаккур, ки бо мо ҳастед! 💚";
        $sms_oson = new SmsController();
        $sms_oson->sendSms($this->selected_order->phone, $message);

        if ($deliver) {
            $sms_delivery = new Telegram();
            $sms_delivery->sms_deliver_boy($deliver->id, $order->id, $this->selected_order->id);
        }
        $this->updateTrackStatuses($user->id, $order->id);

        return redirect()->route('applicant');
        //$$
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
        $this->cleanupIncompleteApplications();
        $this->delivers = User::where('role', 'deliver')->get();
    }
    protected function cleanupIncompleteApplications(): void
    {
        Application::where('status', 'В ожидании')
            ->get()
            ->each(function ($application) {
                $phone = trim((string) $application->phone);
                $address = trim((string) $application->address);

                if (!$this->isValidPhone($phone) || !$this->isValidAddress($address)) {
                    $application->status = 'Отменен';
                    $application->save();
                }
            });
    }

    protected function isValidPhone(?string $phone): bool
    {
        if (empty($phone)) {
            return false;
        }

        return (bool) preg_match('/^\+?[0-9]{7,15}$/', $phone);
    }

    protected function isValidAddress(?string $address): bool
    {
        if (empty($address)) {
            return false;
        }

        $hasEnoughLength = mb_strlen($address) >= 8;
        $notOnlyDigits = !preg_match('/^[0-9]+$/', $address);

        return $hasEnoughLength && $notOnlyDigits;
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
    public function updatedDiscount()
    {
        $this->total_amounts();
    }
    public function updatedDiscountt()
    {
        $this->total_amounts();
    }
    protected function parseNumber($value): float
    {
        if ($value === null || $value === '') {
            return 0.0;
        }

        if (is_string($value)) {
            $normalized = str_replace([' ', ','], ['', '.'], $value);
            if (is_numeric($normalized)) {
                return (float) $normalized;
            }
        }

        return (float) $value;
    }
    protected function roundPrice(float $value): float
    {
        $fraction = $value - floor($value);

        return $fraction > 0.5 ? ceil($value) : floor($value);
    }
    public function total_amounts()
    {
        $weight = $this->parseNumber($this->weight);
        $volume = $this->parseNumber($this->volume);
        $kg_price = (float) $this->getKgPriceTJS();
        $cube_price = (float) $this->getCubePriceTJS();

        // Расчёт стоимости
        if ($weight <= 10) {
            $kg_total = $weight * (float) $this->getKgPriceTJS();
        } elseif ($weight <= 20) {
            $kg_total = $weight * (float) $this->getKgPrice10TJS();
        } elseif ($weight <= 30) {
            $kg_total = $weight * (float) $this->getKgPrice20TJS();
        } else {
            $kg_total = $weight * (float) $this->getKgPrice30TJS();
        }
        $cube_total = $volume * $cube_price;

        // Общая сумма без скидки
        $rawTotal = $kg_total + $cube_total;
        $this->total_amount = max(10, $this->roundPrice($rawTotal));

        $discount = $this->parseNumber($this->discount);
        $this->discount_total = 0;
        if ($discount > 0) {
            $this->discount_total = $this->discountt === 'Процентная' || $this->discountt === 'percent'
                ? $this->total_amount * ($discount / 100)
                : $discount;
        }
        $this->discount_total = min($this->discount_total, $this->total_amount);

        $final = $this->total_amount - $this->discount_total + $this->parseNumber($this->delivery_price);
        $this->total_final = $this->roundPrice(max(0, $final));
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
        $application = Application::find($id);

        if (!$application) {
            $this->dispatch('alert', 'Заявка не найдена или уже была удалена.');
            return;
        }

        $application->status = "Заявщик отмениль";
        $application->save();

        $remaining = Application::where('status', 'В ожидании')->count();
        $currentPage = $this->page ?? 1;
        $maxPage = max(1, (int) ceil($remaining / $this->perPage));

        if ($currentPage > $maxPage) {
            $this->gotoPage($maxPage);
        }

        $this->dispatch('alert', 'Заявка отменена.');
    }
    public function render()
    {
        $pendingCount = Application::where('status', 'В ожидании')->count();
        $readyCount = Application::where('status', 'В ожидании')
            ->whereNotNull('phone')->where('phone', '!=', '')
            ->whereNotNull('address')->where('address', '!=', '')
            ->count();

        $orders = Application::where('status', 'В ожидании')
            ->orderBy('created_at', 'asc')
            ->paginate($this->perPage);

        return view('livewire.applicant', [
            'orders' => $orders,
            'pendingCount' => $pendingCount,
            'readyCount' => $readyCount,
        ]);
    }
}
