<?php
namespace App\Services\Payments\Urway;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Actions\ApiRequestAction;

class UrwayServices {
    public static function generatePaymentUrl($cart) : mixed {
        $res = (new PaymentUrlGenerator($cart))();
        $result = null;
        $payid = null;
        $targetUrl = null;
        foreach ((array)$res as $key => $item) {
            switch ($key) {
                case 'result':
                    $result = $item;
                    break;
                case 'payid':
                    $payid = $item;
                    break;
                case 'targetUrl':
                    $targetUrl = $item;
                    break;
                default:
                    if (is_array($item)) {
                        if (isset($item['result'])) {
                            $result = $item['result'];
                        }
                        if (isset($item['payid'])) {
                            $payid = $item['payid'];
                        }
                        if (isset($item['targetUrl'])) {
                            $targetUrl = $item['targetUrl'];
                        }
                    }
                    break;
            }
        }
        
        return [
            'result' => $result,
            'payid' =>  $payid,
            'targetUrl' => $targetUrl,
        ];
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public static function paymentCallback(
        Request $request
    ) : mixed {

        resolve(ApiRequestAction::class)->handle([
            'name' => 'paymentCallbackUrwayServices',
            'model_name' => 'Transaction',
            'client_id' => auth('api_client')->user()->id ?? NULL,    
            'res' => json_encode($request->all()),
            'http_code' => 200,
        ]);

        return (new PaymentCallback($request))();
    }

    /**
     * @param Transaction $transaction
     * @return bool
     */
    public static function transactionInquiry(
        Transaction $transaction
    ) : bool {
        return (new PaymentInquiry($transaction))();
    }

    /**
     * @param Transaction $transaction
     * @return bool
     * @throws Exception
     * @throws \Exception
     */
    public static function transactionRefund($order) : bool {
        return (new PaymentRefund($order))();
    }
}
