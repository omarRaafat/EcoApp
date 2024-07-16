<?php

use App\Enums\CustomHeaders;
use App\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\OrderService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadFile')) {
    function uploadFile($file, $stringPath)
    {
        // $file = $file;
        $fileName = time().rand(1000, 10000).'.'.$file->getClientOriginalExtension();
        $fileLocation = getcwd().'/'.$stringPath.'/';
        Storage::disk('custom')->put($stringPath. '/'. $fileName,file_get_contents($file));
        if (!$file) {
            return false;
        }
        return $fileName;
    }
}
if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
if (!function_exists('routeIndex')) {
    /**
     * Generate a route name for the previous request.
     *
     * @return string|null
     */
    function routeIndex()
    {
        $url = explode("admin/", url()->current());
        $url = url("/")."/admin/".explode("/", $url[1])[0];
        $currentRequest = app('request')->create($url);
        // try {
        $routeName = app('router')->getRoutes()->match($currentRequest)->getName();
        // } catch (NotFoundHttpException $exception) {
        //     return ['routeName' => '', 'routeUrl' => $url];
        // }
        return ['routeName' => $routeName, 'routeUrl' => $url];
    }
}
//TODO: this function need to replaced with something more accurate and implement good performance
if (!function_exists('orderCode')) {
    function orderCode(): string
    {
        do {
            $code = rand(111111, 999999).substr(time(), -6);
        } while (Order::where("code", "=", $code)->first());

        return $code;
    }
}
//TODO: this function need to replaced with something more accurate and implement good performance
if (!function_exists('orderServiceCode')) {
    function orderServiceCode(): string
    {
        do {
            $code = rand(111111, 999999).substr(time(), -6);
        } while (OrderService::where("code", "=", $code)->first());

        return $code;
    }
}
//TODO: this function need to replaced with something more accurate and implement good performance
if (!function_exists('transactionCode')) {
    function transactionCode(): string
    {
        do {
            $code = rand(111111, 999999).substr(time(), -6);
        } while (Transaction::where("code", "=", $code)->first());

        return $code;
    }
}
if (!function_exists('amountInSar')) {
    function amountInSar(float $amount): float
    {
        return $amount / 100;
    }
}
if (!function_exists('amountInHalala')) {
    function amountInHalala(float $amountSar): float
    {
        return $amountSar * 100;
    }
}
if (!function_exists('amountInSarRounded')) {
    function amountInSarRounded(float $amount): string
    {
        return number_format($amount / 100, 2);
    }
}

if (!function_exists('isAPiInternational')) {
    function isAPiInternational(): bool
    {
        return Str::contains(Route::current()?->uri() ?? "", "api") &&
            request()->hasHeader(CustomHeaders::COUNTRY_CODE);
    }
}

// this helper is helpful when dealing with match between 2 arrays nested like: comparing translation files from 2 branches
if (!function_exists("arrayKeysRecursive")) {
    function arrayKeysRecursive(array $array, $devider = '.')
    {
        $arrayKeys = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $rekusiveKeys = arrayKeysRecursive($value, $devider);
                foreach ($rekusiveKeys as $rekursiveKey) {
                    $arrayKeys[] = $key.$devider.$rekursiveKey;
                }
            } else {
                $arrayKeys[] = $key;
            }
        }
        return $arrayKeys;
    }
}


if (!function_exists('get_settings')) {
    function get_settings(string $type)
    {
        return Setting::query()->where('type', $type)->get();
    }
}

function getSettingByKey(string $key)
{
    return Setting::query()->where('key', $key)->first()?->value ?? asset('images/logo.png');
}

function getSecrectWalletKey()
{
    $encryptedData = Setting::query()->where('key', "secret_wallet_key")->first()?->value;
    if(!$encryptedData) return "";
    return  decryptData($encryptedData, config('eportal.sso_secret'));
}

 // Decryption
 function decryptData($encryptedData, $key) {
    $encryptedData = base64_decode($encryptedData);
    $ivSize = 16; // 128 bits for AES-256-CBC
    $iv = substr($encryptedData, 0, $ivSize);
    $encryptedData = substr($encryptedData, $ivSize);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}



if (!function_exists('ossStorageUrl')) {
    function ossStorageUrl($path = null)
    {
        try {
            if (!$path) {
                return url("/images/noimage.png");
            }
            if (str_contains($path, "noimage.png")) {
                return url($path);
            }
            return \Storage::disk('oss')->url($path);
        } catch (\Throwable $th) {
            //report($th);
        }
        return url($path);
    }
}


function getAddressInfo($lat, $lon): string
{

    $apiKey = 'AIzaSyAj4DOc31MZvYIUQeMADEfb_TpPAVWyH1A';

    $client = new Client();
    $response = $client->get("https://maps.googleapis.com/maps/api/geocode/json?language=ar_SA&latlng=$lat,$lon&key=$apiKey");
    $data = json_decode($response->getBody(), true);

    if ($response->getStatusCode() == 200 && $data['status'] === 'OK') {
        $address = $data['results'][0]['formatted_address'];
        $city = collect($data['results'][0]['address_components'])
            ->filter(function ($component) {
                return in_array('locality', $component['types']);
            })
            ->first();

        $cityName = $city ? $city['long_name'] : null;

        return $cityName ?? $address;
    } else {
        return response()->json(['error' => 'Error getting address'], $response->getStatusCode());
    }
}

if (!function_exists('getParam')) {
    function getParam($name){
        return Setting::where('key' , $name)->first()->value ?? 0;
    }
}
