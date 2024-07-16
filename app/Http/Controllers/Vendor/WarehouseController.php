<?php

namespace App\Http\Controllers\Vendor;

use Execl;
use App\Models\City;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use App\Models\ShippingType;
use Illuminate\Http\Request;
use App\Models\WarehouseStatus;
use App\Models\WarehouseCountry;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Enums\WarehouseIntegrationKeys;
use App\Exports\VendorWarehousesExport;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Vendor\CreateWarehouseRequest;
use App\Http\Requests\Vendor\UpdateWarehouseRequest;

class WarehouseController extends Controller
{
    /**
     * @param  Request $request
     * @return View
     */
    public function index(Request $request): View | RedirectResponse
        {
        
        
        $user = auth()->user();
        if (!empty($user->vendor)) $warehouses =
            Warehouse::query()->where('vendor_id' , $user->vendor->id)
                            ->when($request->has("search") ,function ($q) use ($request){
                                $q->when($request->trans != "all" , function ($query) use ($request){
                                    $query->where('name->' . $request->trans, 'LIKE', "%{$request->search}%");
                                })->when($request->trans == "all" , function ($query) use ($request){
                                    $query->where('name->ar', 'LIKE', "%{$request->search}%")
                                        ->orWhere('name->en', 'LIKE', "%{$request->search}%");
                                });
                            })
                            ->orderBy("created_at", 'DESC')
                            ->paginate(10);

                          

                            

        return view('vendor.warehouse.index' , get_defined_vars());
    }

    /**
     * @return View|RedirectResponse
     */
    public function create()
    {
//        $countries = Country::active()->select("name", "id")->get();
//        if($countries->isEmpty()) return redirect(route('vendor   .warehouses.index'))->with("error", __("admin.warehouses.empty-countries"));

        $shipping_types = ShippingType::query()->get();
        $cities = City::active()->select("name", "id")->get();
        $integrationKeys     = WarehouseIntegrationKeys::getKeys();
        return view('vendor.warehouse.create' , get_defined_vars());
    }

    /**
     * @param CreateWarehouseRequest $request
     * @return RedirectResponse
     */
    public function store(CreateWarehouseRequest $request): RedirectResponse
    {

//        dd($request->all());
        try{
            if(in_array(2 , $request->shipping_type)) {
                $check = Warehouse::query()->where('vendor_id', auth()->user()->vendor->id)
                    ->whereHas('shippingTypes', function ($q) {
                        $q->where('shipping_type_id', 2);
                    })->get();

                if ($check->count() > 0)
                    return redirect(route('vendor.warehouses.index'))->with("error", __("admin.vendor-has-deliver-warehouse"));
            }

            $request->merge([
                'vendor_id' => auth()->user()->vendor->id
            ]);
            if (isset($request['days']) && $request['days'] != NULL) $request['days'] = json_encode($request->days);

            //set status to PENDING
            
            $warehouse = Warehouse::query()->create(
                $request->except('_method', '_token' , 'shipping_type')
            );

            WarehouseStatus::create([
                'warehouse_id' => $warehouse->id,
                'status' => Warehouse::PENDING
            ]);

            $cityId = is_array($request['cities']) ? head($request['cities']) : $request['cities'];
            $warehouse->cities()->attach($cityId);
    
            $warehouse->shippingTypes()->attach($request['shipping_type']);

            $warehouse->splInfo()->updateOrCreate(
                ['warehouse_id' => $warehouse->id],
                ['branch_id' => $request->spl_branch_id],
            );

            Alert::success(
                trans("admin.warehouses.messages.created_successfully_title"),
                trans("admin.warehouses.messages.created_successfully_body"));
        }catch(\Exception $ex){
            Alert::error(
                trans("admin.warehouses.messages.created_error_title"),
                $ex->getMessage());
        }

        return to_route('vendor.warehouses.index');
    }

    /**
     * @param  int $id
     * @return View
     */
    public function show(int $id): View
    {
        $user = auth()->user();
        $warehouse = Warehouse::query()->where([
            'id' => $id,
            'vendor_id' => $user->vendor->id,

        ])->first();

        abort_if(empty($warehouse) , 404);
        return view('vendor.warehouse.show' , get_defined_vars());
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
//        $countries = Country::active()
//            ->where(
//                function($q) use ($id) {
//                    $q->whereDoesntHave('warehouseCountry');
//                    $q->orWhereHas('warehouseCountry', function ($_q) use ($id) {
//                        return $_q->where('warehouse_id', $id);
//                    });
//                }
//            )
//            ->select("name", "id")->get();

        $cities = City::active()->select("name", "id")->get();
        $user = auth()->user();
        $warehouse = Warehouse::query()->where([
            'id' => $id,
            'vendor_id' => $user->vendor->id,

        ])->first();
        $shipping_types = ShippingType::query()->get();
        abort_if(empty($warehouse) , 404);
        abort_if($warehouse->isWaitUpdated() , 404);
        return view('vendor.warehouse.update' , get_defined_vars());
    }

    /**
     * @param  UpdateWarehouseRequest $request
     * @param  int $id
     * @return RedirectResponse
     */
    public function update(UpdateWarehouseRequest $request, int $id)
    {
           
       
        try{
            if(in_array(2 , $request->shipping_type)) {
                $check = Warehouse::query()->where('vendor_id', auth()->user()->vendor->id)
                    ->whereHas('shippingTypes', function ($q) use ($id){
                        $q->where('shipping_type_id', 2)->where('warehouse_id', '<>' , $id);
                    })->get();

                if ($check->count() > 0)
                    return redirect(route('vendor.warehouses.index'))->with("error", __("admin.vendor-has-deliver-warehouse"));
            }
            $warehouse = Warehouse::query()->findOrFail($id);
            if (isset($request['days']) && $request['days'] != NULL) $request['days'] = json_encode($request->days);

            
            $cityId = is_array($request['cities']) ? head($request['cities']) : $request['cities'];

            // مرفوض غير موافق عليه بعد
            if($warehouse->isRejected()){
                $warehouse->name = $request->name;
                $warehouse->torod_warehouse_name = $request->torod_warehouse_name;
                $warehouse->administrator_name = $request->administrator_name;
                $warehouse->administrator_phone = $request->administrator_phone;
                $warehouse->administrator_email = $request->administrator_email;
                $warehouse->latitude = $request->latitude;
                $warehouse->longitude = $request->longitude;
                $warehouse->package_price = $request->package_price;
                $warehouse->package_covered_quantity = $request->package_covered_quantity;
                $warehouse->address = $request->address;
                $warehouse->postcode = $request->postcode;
                $warehouse->additional_unit_price = $request->additional_unit_price;
                $warehouse->days = $request['days'] ;

                $warehouse->save();

                $warehouse->cities()->sync([$cityId]);
    
                $warehouse->splInfo()->updateOrCreate(
                    ['warehouse_id' => $warehouse->id],
                    ['branch_id' => $request->spl_branch_id],
                );

                $warehouse->shippingTypes()->sync($request['shipping_type']);

                WarehouseStatus::create([
                    'warehouse_id' => $warehouse->id,
                    'status' => Warehouse::PENDING,
                ]);
            }
            else{
                $data = [];
                $keys = $warehouse->getFillable();
                unset($keys[array_search("vendor_id", $keys)]);                
                unset($keys[array_search("type", $keys)]);                
                unset($keys[array_search("name", $keys)]);                
                unset($keys[array_search("address", $keys)]);                
                $keys = array_values($keys);
                foreach ($keys as $index => $keyy) {
                  
                    $reqVal = $request->$keyy;
                    $warehouseVal = $warehouse->$keyy;
                   if($warehouseVal != $reqVal){
                    if($keyy == "days" && json_decode($reqVal) == json_decode($warehouseVal)){
                        continue;
                    }
                    if($keyy == 'is_active'){
                        // $warehouseVal =   $warehouse->is_active == 1?   'Active' : 'Inactive'; 
                        // $reqVal =   $request->is_active == 1?   'Active' : 'Inactive';
                        
                    }
                    array_push($data,[
                        'key' => $keyy,
                        'old' => $warehouseVal,
                        'new' => $reqVal 
                        ]
                    );
                   }
                }
                // return $data;
                if($warehouse->splInfo->branch_id != $request->spl_branch_id){
                    array_push($data,[
                        'key' => "branch_id",
                        'old' => $warehouse->splInfo->branch_id,
                        'new' => $request->spl_branch_id 
                        ]
                    );
                }
                if($warehouse->getTranslation('name', 'ar') != $request->name['ar']){
                    array_push($data,[
                        'key' => "name",
                        'old' => $warehouse->getTranslation('name', 'ar'),
                        'new' => $request->name['ar']
                        ]
                    );
                }
                if(isset($warehouse->cities[0]->id) && $warehouse->cities[0]->id != $cityId){
                    array_push($data,[
                        'key' => "city",
                        'old' => $warehouse->cities[0]->id,
                        'oldLabel' =>  City::find($warehouse->cities[0]->id)->name,
                        'new' => $cityId,
                        'newLabel' =>  City::find($cityId)->name,
                        ]
                    );
                }elseif (!isset($warehouse->cities[0]->id)) {
                    array_push($data,[
                            'key' => "city",
                            'new' => $cityId,
                            'newLabel' =>  City::find($cityId)->name,
                        ]
                    );
                }
                if($warehouse->getTranslation('address', 'en') != $request->address['en']){
                    array_push($data,[
                        'key' => "address",
                        'old' => $warehouse->getTranslation('address', 'en'),
                        'new' => $request->address['en']
                        ]
                    );
                }
                if($warehouse->shippingTypes->pluck('id')->toArray() != $request->shipping_type){
                    array_push($data,[
                        'key' => "shipping_type",
                        'old' => $warehouse->shippingTypes->pluck('id')->toArray(),
                        'oldLabel' =>  ShippingType::whereIn('id',$warehouse->shippingTypes->pluck('id')->toArray())->pluck('title')->toArray(),
                        'new' => $request->shipping_type,
                        'newLabel' =>  ShippingType::whereIn('id',$request->shipping_type)->pluck('title')->toArray(),
                        ]
                    );
                }

                if(empty($data)){
                    return to_route('vendor.warehouses.index');
                }

                WarehouseStatus::create([
                    'warehouse_id' => $warehouse->id,
                    'status' => Warehouse::UPDATED,
                    'data' => $data,
                ]);
            }

            Alert::success(
                trans("admin.warehouses.messages.updated_successfully_title"),
                trans("admin.warehouses.messages.updated_successfully_body"));
        }catch(\Exception $ex){
            Alert::error(
                trans("admin.warehouses.messages.created_error_title"),
                $ex->getMessage());
        }

        return to_route('vendor.warehouses.index');
    }

    /**
     * @param  int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        /*
        try{
            Warehouse::query()->findOrFail($id)->delete();
            WarehouseCountry::query()->where('warehouse_id', $id)->delete();

            Alert::success(
                trans("admin.warehouses.messages.deleted_successfully_title"),
                trans("admin.warehouses.messages.deleted_successfully_message")
            );

        }catch(\Exception $ex){
            Alert::error(
                trans("admin.warehouses.messages.deleted_error_title"),
                $ex->getMessage());
        }
        */

        return back();
    }

    public function excel(Request $request)
    {   
      
        return Excel::download(new VendorWarehousesExport($request), 'warehouses '.date('d-m-Y').'-'.Str::random(1).'.xlsx');
    }
}
