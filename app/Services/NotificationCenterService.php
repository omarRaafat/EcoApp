<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NotificationCenterService
{
    /**
     * Sent Notification message throw sms
     *
     * @param array $payload
     * @return void
     */
    public function toSms(array $payload) : void
    {
        $user = $payload["user"];
        $message = $payload["message"];

        $smsPayload = [
            "userName" => config("msegat.userName"),
            "numbers" => $user['phone'],
            "userSender" => config("msegat.userSender"),
            "apiKey" => config("msegat.apiKey"),
            "msg" => $payload["message"]
        ];

        $response = Http::withHeaders([
            "Content-Type" => "application/json"
        ])->timeout(60)
        ->post(config("msegat.apiUrl"), $smsPayload);

        Log::channel('sms')->info("Sending SMS", [
            "service_type" => "SMS",
            "user" => $user,
            "message" => $message,
            "response" => $response->json(),
            "datetime" => now()
        ]);
    }

    /**
     * Sent Notification message throw sms
     *
     * @param array $payload
     * @return void
     */
    public function toMail(array $payload) : void
    {
        $user = $payload["user"];
        $message = $payload["message"];

        $response = [];

        Log::info([
            "service_type" => "Email",
            "user" => $user,
            "message" => $message,
            "response" => $response,
            "datetime" => now()
        ]);
    }
}
