<?php

namespace App\Services;

class SendSms
{
    public static  function toSms($number, $msg){
        try {
            if(env('APP_ENV') == 'local'){
                \Log::notice('number: ' .$number. ' | msg: ' . $msg);
                return [true];
            }

            $number = str_replace('+966','',$number);
            if(strlen($number) == 10 || strlen($number) == 9){
                $number = '966'.(int)$number;
            }

            $url = 'https://www.msegat.com/gw/sendsms.php';
            $fields = array(
                "userName"=> "NCPD",
                "numbers"=>  $number,
                "userSender"=> config('sms.msegat.username'),
                "apiKey"=> config('sms.msegat.key'),
                "msg"=> $msg,
                "msgEncoding"=>"UTF8"
            );
            $postvars = http_build_query($fields);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://www.msegat.com/gw/sendsms.php");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json",
                )
            );

            $response = curl_exec($ch);

            if(curl_errno($ch)){
                return [false,$ch];
            }
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if(intval($httpcode) != 200){
                return [false,$httpcode];
            }

            $text = '';
            $start = '{';
            $end = '}';

            $pattern = sprintf(
                '/%s(.+?)%s/ims',
                preg_quote($start, '/'), preg_quote($end, '/')
            );

            if (preg_match($pattern, $response, $matches)) {
                list(, $match) = $matches;
                $text =  $match;
            }

            $text = "{".$text."}";
            $response_array = json_decode($text);
            
            if(intval($response_array->code) != 1){
                return [false,$response_array->message];
            }

            return [true];

        } catch (\Throwable $th) {
            report($th);
        }
    }
}
