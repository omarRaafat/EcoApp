<?php
namespace App\Actions;

use App\Models\ApiRequest;

class ApiRequestAction{

    public function handle($data){
        try {
            ApiRequest::create([
                'name' => $data['name'],
                'model_name' => (isset($data['model_name'])) ? $data['model_name'] : null,
                'model_id' => (isset($data['model_id'])) ? $data['model_id'] : null,
                'client_id' => (isset($data['client_id'])) ? $data['client_id'] : null,
                'url' => $data['url'],
                'req' => $data['req'],
                'res' => (isset($data['res'])) ? $data['res'] : null,
                'http_code' => (isset($data['http_code'])) ? $data['http_code'] : null,
                'dataUpdated' => (isset($data['dataUpdated'])) ? $data['dataUpdated']: null,
            ]);
        } catch (\Throwable $th) {
           report($th);
        }
    }
}