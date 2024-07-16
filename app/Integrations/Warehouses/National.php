<?php
    namespace App\Integrations\Warehouses;

    use App\Models\Transaction;
    use App\Models\VendorWarehouseRequest;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Log;

    class National
    {
        private Const USERNAME = "";
        private Const PASSWORD = "";
        private Const API_URL = "/";
        private $_token = null;
        private Const END_POINTS = [
            'Auth' => '',
            'vendor_warehouse_request' => '',
            'customer_transaction' => ''
        ];

        private function __construct()
        {
            self::Authorize();
        }

        private function setToken($token)
        {
            $this->_token = $token;
        }

        private function getToken()
        {
            return $this->_token;
        }

        private function Authorize(): void
        {
            $response = Http::post(self::API_URL . self::END_POINTS['Auth'], [
                'username' => self::USERNAME,
                'password' => self::PASSWORD,
            ]);

            //TODO : check response Status
            //$response->status()
            //$response->successful() : bool;
            //$response->failed() : bool;

            self::setToken($response->body()['token']);
        }

        private function __vendor_warehouse_request_payload(VendorWarehouseRequest $vendor_warehouse_request): string
        {
            //TODO : generate payload and return it
            return 'payload';
        }

        public function creat_vendor_warehouse_request(VendorWarehouseRequest $vendor_warehouse_request)
        {
            $token = self::getToken();
            $payload = self::__vendor_warehouse_request_payload($vendor_warehouse_request);
            self::logger('',$payload,FALSE);
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post(self::API_URL . self::END_POINTS['vendor_warehouse_request'],$payload);

            //TODO : check if response is successful and then return response
            //$response->status()
            //$response->successful() : bool;
            //$response->failed() : bool;
            if($response->failed())
            {
                self::logger($response->object()['message'],$response->object()['data'],TRUE);
            }
            else
            {
                self::logger($response->object()['message'],$response->object()['data'],FALSE);
            }

            return $response->object();
        }

        private function __customer_transaction_payload(Transaction $customer_transaction): string
        {
            //TODO : generate payload and return it
            return 'payload';
        }

        public function creat_customer_transaction(Transaction $customer_transaction)
        {
            $token = self::getToken();
            $payload = self::__customer_transaction_payload($customer_transaction);
            self::logger('',$payload,FALSE);
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post(self::API_URL . self::END_POINTS['customer_transaction'],$payload);

            //TODO : check if response is successful and then return response
            //$response->status()
            //$response->successful() : bool;
            //$response->failed() : bool;
            if($response->failed())
            {
                self::logger($response->object()['message'],$response->object()['data'],TRUE);
            }
            else
            {
                self::logger($response->object()['message'],$response->object()['data'],FALSE);
            }
            return $response->object();
        }

        private function logger(string $message = '',object $context,bool $fail)
        {
            if($fail)
            {
                Log::channel('national-warehouse')->error($message,$context);
            }
            else
            {
                Log::channel('national-warehouse')->info($message,$context);
            }
        }
    }