<?php
namespace App\Http\Controllers\Api;
use App\Http\Resources\Api\AreaResource;
use App\Models\Area;
use App\Services\Api\BlogPostService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\DeliveryToRequest;
use App\Services\Api\CountryService;
use App\Models\City;

class CountryController extends ApiController
{
    /**
     * BlogPost Controller Constructor.
     *
     * @param BlogPostService $blog
     * @param CountryService @service
     */
    public function __construct(public CountryService $service) {}

    public function index()
    {
        $areas = Area::active()->get();
        return AreaResource::collection($areas)->additional([
            "success" => true,
            "status" => 200,
            "message"=> trans("address.api.retrieved_geo_data_successfully")
        ]);
    }

    /**
     * Get BlogPost using id.
     *
     * @param id $BlogPost_id
     * @return JsonResponse
     */
    public function deliveryTo(DeliveryToRequest $request)
    {
        $response = $this->service->setCountryDeliveryToUser($request->validated());

        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    public function warehousesCities(){
        $cities = City::active()->whereHas('warehouses')->select("name", "id")
        ->when(!empty(request()->get('vendor_id')),function($qr){
            $qr->whereHas('warehouses',function($qr2){
                $qr2->whereHas('warehouse',function($qr3){
                    $qr3->where('vendor_id',intval(request()->get('vendor_id')));
                });
            });
        })
        ->get();

        return $this->setApiResponse(true, 200, $cities, '');
    }

    public function servicesCities(){
        $cities = City::active()->whereHas('services')->select("name", "id")
        ->when(!empty(request()->get('vendor_id')),function($qr){
            $qr->whereHas('services',function($qr2){
                $qr2->whereHas('service',function($qr3){
                    $qr3->where('vendor_id',intval(request()->get('vendor_id')));
                });
            });
        })
        ->get();

        return $this->setApiResponse(true, 200, $cities, '');
    }
}
