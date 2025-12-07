<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    public function sendSms($phone, $message)
    {
        $config = [
            'login' => 'Shifu Cargo',
            'hash' => '20a29830bddb42f370829357b6680e5e',
            'sender' => 'shifucargo',
            'server' => 'https://api.osonsms.com/sendsms_v1.php',
        ];

        $dlm = ";";
        $phone_number = $phone;
        $txn_id = uniqid();
        $str_hash = hash('sha256', $txn_id . $dlm . $config['login'] . $dlm . $config['sender'] . $dlm . $phone_number . $dlm . $config['hash']);

        $params = [
            "from" => $config['sender'],
            "phone_number" => $phone_number,
            "msg" => $message,
            "str_hash" => $str_hash,
            "txn_id" => $txn_id,
            "login" => $config['login'],
        ];

        $response = Http::get($config['server'], $params);

        if ($response->successful()) {
            $data = $response->json();
            return "SMS успешно отправлено. ID сообщения: " . $data['msg_id'];
        } else {
            return "Произошла ошибка при отправке SMS. Подробности: " . $response->body();
        }
    }
}
