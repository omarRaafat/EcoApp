<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EportalAuthController
{

    public function redirect(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => config('eportal.client_id'),
            'redirect_uri' =>  config('eportal.client_callback'),
            'state' => $state,
        ]);

        return redirect(config('eportal.sso_url').'common/oauth/authorize?' . $query);

    }

    public function callback(Request $request)
    {

        $state = $request->session()->pull('state');

        if ($this->isStateNotValid($request->state,$state,$request->code)) return $this->redirectToMouzareFrontend(null, 0);

        $response = $this->getAccessToken($request->code);

        if ($response->failed()) return $this->redirectToMouzareFrontend(null, 0);

        $accessToken = $response->json()['access_token'];

        $clientResponse = $this->getEFarmerAuthenticatedClient($accessToken);

        if ($clientResponse->failed()) return $this->redirectToMouzareFrontend(null, 0);

        $client = $clientResponse->json();

        $this->updateOrInsertClient($client,$accessToken);

        return $this->redirectToMouzareFrontend($accessToken);

    }

    private function getEFarmerAuthenticatedClient($token)
    {
        return Http::withToken($token)->get(config('eportal.sso_url') . 'api/oauth/get-user');
    }

    private function getAccessToken($code){
       return Http::asForm()->post(config('eportal.sso_url') . 'api/oauth/get-token', [
            'client_id' => config('eportal.client_id'),
            'client_secret' =>  config('eportal.client_secret'),
            'code' => $code,
        ]);
    }
    private function updateOrInsertClient($client,$accessToken)
    {
        return Client::updateOrInsert(
            [
                'identity' => $client['identity'],
            ],
            [
                'name' => $client['name'],
                'phone' => $client['phone'],
                'birthDate' => $client['birthDate'],
                'token' => $accessToken
            ]
        );
    }

    private function redirectToMouzareFrontend($token = '', $success = 1)
    {
        $query = http_build_query([
            'success' => $success,
            'token' =>  $token,
        ]);

        return redirect(config('eportal.mouzare_frontend_callback').'?' . $query);
    }

    private function isStateNotValid($stateRequest,$state,$requestCode)
    {
        return is_null($state) || is_null($requestCode) || strlen($state) > 0 && $state !== $stateRequest;
    }
}
