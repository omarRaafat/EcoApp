<?php

namespace App\Http\Controllers\Admin;

use App\Enums\WarehouseIntegrationKeys;
use App\Exports\WarehousesExport;
use App\Models\City;
use App\Models\ShippingType;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Services\Admin\WarehouseService;
use App\Http\Controllers\Controller;
use Illuminate\Http\View;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Admin\CreateWarehouseRequest;
use App\Http\Requests\Admin\UpdateWarehouseRequest;
use App\Models\WarehouseCountry;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\WarehouseStatus;

class WarehouseController extends Controller
{
    public $service;

    /**
     * Warehouse Controller Constructor.
     *
     * @param WarehouseService $service
     */
    public function __construct(WarehouseService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $request['status'] = Warehouse::ACCEPTED;
        $warehouses = $this->service->getAllWarehousesWithPagination($request);
        $shipping_types = ShippingType::query()->get();
        $vendors = Vendor::available()->get();
        return view("admin.warehouses.index", compact('warehouses','shipping_types','vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $vendors = Vendor::all();
        $shipping_types = ShippingType::query()->get();
        $cities = City::active()->select("name", "id")->get();
//        if($countries->isEmpty()) return redirect(route('admin.warehouses.index'))->with("error", __("admin.warehouses.empty-countries"));
        $breadcrumbParent = 'admin.warehouses.index';
        $breadcrumbParentUrl = route('admin.warehouses.index');
        $integrationKeys = WarehouseIntegrationKeys::getKeys();

        return view("admin.warehouses.create", get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWarehouseRequest  $request
     * @return Redirect
     */
    public function store(CreateWarehouseRequest $request)
    {
        if(in_array(2 , $request->shipping_type))
        {
            $check = Warehouse::query()->where('vendor_id' , $request->vendor_id)
                ->whereHas('shippingTypes', function ($q) {
                    $q->where('shipping_type_id' , 2);
                })->get();

            if($check->count() > 0)
                return redirect(route('admin.warehouses.index'))->with("error", __("admin.vendor-has-deliver-warehouse"));
        }

        $result = $this->service->createWarehouse($request);


        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.warehouses.show", $result["id"]);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show(int $id)
    {
        $warehouse = $this->service->getWarehouseUsingID($id);
        $breadcrumbParent = 'admin.warehouses.index';
        $breadcrumbParentUrl = route('admin.warehouses.index');

        return view("admin.warehouses.show", compact('warehouse', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id)
    {
        $vendors = Vendor::all();
        $shipping_types = ShippingType::query()->get();
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
        $warehouse = $this->service->getWarehouseUsingID($id)->load('countries');
        $breadcrumbParent = 'admin.warehouses.index';
        $breadcrumbParentUrl = route('admin.warehouses.index');
        $integrationKeys = WarehouseIntegrationKeys::getKeys();

        return view("admin.warehouses.edit", get_defined_vars());
    }

    /**
     * Update resource in storage using ID
     *
     * @param  UpdateWarehouseRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdateWarehouseRequest $request, int $id)
    {

//        dd($request->all());
        if(in_array(2 , $request->shipping_type)) {
            $check = Warehouse::query()->where('vendor_id', $request->vendor_id)
                ->whereHas('shippingTypes', function ($q) use ($id){
                    $q->where('shipping_type_id', 2)->where('warehouse_id', '<>' , $id);
                })->get();

            if ($check->count() > 0)
                return redirect(route('admin.warehouses.index'))->with("error", __("admin.vendor-has-deliver-warehouse"));
        }

        $result = $this->service->updateWarehouse($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.warehouses.show", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete Warehouse Using ID.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function destroy(int $id)
    {
        $result = $this->service->deleteWarehouse($id);
        WarehouseCountry::where('warehouse_id', $id)->delete();

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.warehouses.index');
    }

    public function excel(Request $request)
    {
        return Excel::download(new WarehousesExport($request), 'warehouses.xlsx');
    }


    public function pending(Request $request)
    {
        $request['status'] = Warehouse::PENDING;
        $warehouses = $this->service->getAllWarehousesWithPagination($request);
        $shipping_types = ShippingType::query()->get();
        $vendors = Vendor::available()->get();
        return view("admin.warehouses.index", compact('warehouses','shipping_types','vendors'));
    }

    public function accepting($id){
        $warehouse = Warehouse::pending()->findOrFail($id);

        WarehouseStatus::create([
            'warehouse_id' => $warehouse->id,
            'status' => Warehouse::ACCEPTED,
        ]);

        Alert::success('نجاح', 'تم الموافقة بنجاح');
        return redirect()->route('admin.warehouses.pending');
    }

    public function reject($id, Request $request){
        $request->validate([
            'reason' => 'required|string|min:3|max:10000',
        ]);
        
        $warehouse = Warehouse::pending()->findOrFail($id);

        WarehouseStatus::create([
            'warehouse_id' => $warehouse->id,
            'status' => Warehouse::REJECTED,
            'note' => $request->reason
        ]);

        Alert::success('نجاح', 'تم الرفض بنجاح');
        return redirect()->route('admin.warehouses.pending');
    }

    public function updated(Request $request)
    {
        $request['status'] = Warehouse::UPDATED;
        $warehouses = $this->service->getAllWarehousesWithPagination($request);
        $shipping_types = ShippingType::query()->get();
        $vendors = Vendor::available()->get();
        return view("admin.warehouses.index", compact('warehouses','shipping_types','vendors'));
    }

    public function refuseUpdate($id, Request $request){
        $request->validate([
            'reason' => 'required|string|min:3|max:10000',
        ]);
        
        $warehouse = Warehouse::findOrFail($id);

        WarehouseStatus::create([
            'warehouse_id' => $warehouse->id,
            'status' => Warehouse::UPDATE_REFUSED,
            'note' => $request->reason
        ]);

        Alert::success('نجاح', 'تم رفض التعديل');
        return redirect()->route('admin.warehouses.updated');
    }

    public function acceptUpdate($id, Request $request){
        $warehouse = Warehouse::with("getLastStatus")->findOrFail($id);

        $this->updateDataWarehouse($warehouse);

        WarehouseStatus::create([
            'warehouse_id' => $warehouse->id,
            'status' => Warehouse::ACCEPTED,
        ]);

        Alert::success('نجاح', 'تم الموافقة بنجاح');
        return redirect()->route('admin.warehouses.updated');
    }

    private  function updateDataWarehouse($warehouse){
        foreach ($warehouse->getLastStatus->data as $index => $item) {
            if($item['key'] ==  "branch_id"){
                $warehouse->splInfo()->updateOrCreate(
                    ['warehouse_id' => $warehouse->id],
                    ['branch_id' => $item['new']],
                );
            }
            elseif($item['key'] ==  "shipping_type"){
                $warehouse->shippingTypes()->sync($item['new']);
            }
            elseif($item['key'] ==  "name"){
                $warehouse->name = ['ar'=>$item['new']];
            }
            elseif($item['key'] ==  "address"){
                $warehouse->address = ['en'=>$item['new']];
            }
            elseif($item['key'] ==  "city"){
                $warehouse->cities()->sync([$item['new']]);
            }
            else{
                $keylabel=$item['key'];
                 $warehouse->$keylabel = $item['new'];
            }
        };

    
        $warehouse->save();
    }
}
