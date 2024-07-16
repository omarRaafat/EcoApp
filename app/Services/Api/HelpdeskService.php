<?php
namespace App\Services\Api;

use App\Models\GuestCustomer;
use App\Services\Eportal\Connection;
use Error;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Api\SendInqueryRequest;
use Illuminate\Support\Facades\Log;
use App\Actions\ApiRequestAction;

class HelpdeskService
{
    ///// NEW CODE

    /**
     * @param SendInqueryRequest $request
     * @return bool
     */
    public  function  sendInquiry(SendInqueryRequest $request): bool
    {
        return config("help-disk.env") == "old" ?
            $this->sendToNcpdOldHelpDesk($request) :
            $this->sendToNcpdNewHelpDesk($request);
    }

    /**
     * @param SendInqueryRequest $request
     * @return boolean
     */
    private function sendToNcpdOldHelpDesk(SendInqueryRequest $request): bool
    {
        $user = null;
        if(auth('api_client')->check()) {
            $user = auth('api_client')->user();
        }
       
        $data = [
            'token' => config("help-disk.access_token"),
            'title' => $request->get("title") ?? "",
            'desc' => $request->get("desc") ?? "",
            'category' => ($request->get("category") ==  "الاستفسارات") ?
                config("help-disk.category_token.inquiries_token") : config("help-disk.category_token.complaints_token"),
            'user_type' => $user ? "عميل" : "زائر",
            'name' => $user ? $user->name : $request->get("name", ""),
            'email' => $request->get("email", "info@me.com"),
            'phone' => $user ? $user->phone : $request->get("phone", ""),
            'file' => null,
        ];
        if ($request->hasFile("file")) $data["file"] = $request->file("file");
        try {
            $url = config("help-disk.api_url");
            $response = Http::withHeaders([
                'Accept' => "application/json",
                'Content-Type' => "application/json"
            ])->post($url, $data);

            resolve(ApiRequestAction::class)->handle([
                'name' => 'sendToNcpdOldHelpDesk',
                'url' => $url,
                'req' => json_encode($data),
                'res' => $response->getBody()->getContents(),
                'http_code' => $response->status(),
            ]);

            return $response->successful();
        } catch (Exception | Error | RequestException $e) {
            Log::error("Error in sending a contact us to help desk system, message: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * @param SendInqueryRequest $request
     * @return boolean
     */
    private function sendToNcpdNewHelpDesk(SendInqueryRequest $request): bool
    {

        $user = null;
        $names= [];
        if(auth()->guard('api_client')->check()){
            $user = auth()->guard('api_client')->user();
            $names = $this->extractNames($user->name);
        }
        else{
            $names = $this->extractNames($request->name);
        }

        $data = [
            "secret" => config("help-disk.access_token"),
            "data" => [
                "mailbox_id" => config("help-disk.mailbox_id"), // as requested by client, it'll be static
                "type" => 1, // as requested by client, it'll be static
                "category_id" => match($request->get("category")) {
                    "الاستفسارات" => 2,
                    "الشكاوي" => 1,
                    default => 1,
                },
                "subject" => $request->get("title", ""),
                "body" => $request->get("desc", ""),
                "source" =>"منصة مزارع",
                "customer" => [
                    "phone" => $user ? $user->phone : $request->get("phone", ""),
                    "email" => $request->get("email", "info@me.com"),
                    "first_name" => $names['first_name'] ?? '' ,
                    "last_name" => $names['last_name'] ?? '-',
                    "notes" => ""
                ],
            ],
            "event" => "conversation.create"
        ];
        $data['data']['customer']['phone'] = str_replace("+", "00", $data['data']['customer']['phone']);
        try {
            $url = config("help-disk.api_url"). "/api/service/conversations/create";
            $response = Http::withHeaders([
                'Accept' => "application/json",
                'Content-Type' => "application/json"
            ])->post($url, $data);

            unset($data['secret']);
            resolve(ApiRequestAction::class)->handle([
                'name' => 'sendToNcpdNewHelpDesk',
                'url' => $url,
                'req' => json_encode($data),
                'res' => $response->getBody()->getContents(),
                'http_code' => $response->status(),
            ]);


          //  Log::debug("HelpDeskService", ['data' => $data, 'response' => $response]);
            return $response->successful();
        } catch (Exception | Error | RequestException $e) {
            Log::error("Error in sending a contact us to help desk system, message: {$e->getMessage()}");
            return false;
        }
    }

    private function extractNames($fullName) {
        $nameParts = explode(' ', trim($fullName));
        $firstName = array_shift($nameParts);
        $lastName = implode(' ', $nameParts);
        return ['first_name' => (!empty($firstName)) ? $firstName : $fullName, 'last_name' => (!empty($lastName)) ? $lastName : ' empty'];
    }
}
