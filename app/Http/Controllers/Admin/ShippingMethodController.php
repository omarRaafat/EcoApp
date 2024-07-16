<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Delivery\CreateShippingMethodRequest;
use App\Http\Requests\Admin\Delivery\UpdateShippingMethodRequest;
use App\Enums\ShippingMethodKeys;
use App\Enums\ShippingMethodType;
use App\Http\Requests\Admin\Delivery\ShippingMethodSyncZonesRequest;
use App\Models\DomesticZone;
use App\Models\DomesticZoneMeta;
use App\Models\OrderVendorShipping;
use App\Models\ShippingMethod;
use RealRashid\SweetAlert\Facades\Alert;

class ShippingMethodController extends Controller
{
    private string $view;

    public function __construct() {
        $this->view = 'admin/shipping_methods/';
    }

    public function index(Request $request)
    {
        $shippingMethods = ShippingMethod::query()
            ->when(
                $request->has("search"),
                function ($query) use ($request) {
                    $query->when(
                        $request->has("trans") && $request->trans != "all",
                        fn($q) => $q->where('name->' . $request->trans, 'LIKE', "%{$request->input('search')}%")
                    )
                    ->when(
                        $request->has("trans") && $request->trans == "all",
                        fn($q) => $q->where('name->ar', 'LIKE', "%{$request->input('search')}%")
                        ->orWhere('name->en', 'LIKE', "%{$request->input('search')}%")
                    );
                }
            )
            ->paginate(10);
        return view($this->view .'index', [
            'shippingMethods' => $shippingMethods,
        ]);
    }

    public function create()
    {
        return view( $this->view .'create', [
            'integrationKeys' => ShippingMethodKeys::getKeys(),
            'shipping_types' => ShippingMethodType::getTypesList(),
            'breadcrumbParent' => 'admin.shippingMethods.index',
            'breadcrumbParentUrl' => route('admin.shipping-methods.index'),
        ]);
    }

    public function store(CreateShippingMethodRequest $request)
    {
        $id = ShippingMethod::create($request->validated())->id;
        Alert::success('success', __('admin.shippingMethods.messages.created_successfully_title'));
        // return back();

        return redirect()->route("admin.shipping-methods.index");
    }

    public function show($id)
    {
        $shippingMethod = ShippingMethod::findOrFail($id);
        return view($this->view .'show', [
            'shippingMethod' => $shippingMethod->load('domesticZones'),
            'breadcrumbParent' => 'admin.shippingMethods.index',
            'breadcrumbParentUrl' => route('admin.shipping-methods.index'),
            'domesticZones' => DomesticZone::type($shippingMethod->type)->select('id', 'name')->get()
        ]);
    }

    public function edit($id)
    {
        // dd('zz');
        return view($this->view .'edit', [
            'shippingMethod' => ShippingMethod::findOrFail($id),
            'integrationKeys' => ShippingMethodKeys::getKeys(),
            'shipping_types' => ShippingMethodType::getTypesList(),
            'breadcrumbParent' => 'admin.shippingMethods.index',
            'breadcrumbParentUrl' => route('admin.shipping-methods.index'),
        ]);
    }

    public function update(UpdateShippingMethodRequest $request, $id)
    {
        $shippingMethod = ShippingMethod::findOrFail($id);
        
        $shippingMethod->update($request->validated());
        Alert::success('success', __('admin.shippingMethods.messages.updated_successfully_title'));

        return redirect()->route("admin.shipping-methods.index");

    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        
        $orderShippings = OrderVendorShipping::where('shipping_method_id' , $shippingMethod->id)->exists();
        if ($orderShippings) {
            Alert::error(
                __('admin.shippingMethods.messages.deleted_error_message'),
                __('admin.shippingMethods.messages.has_transaction_error_message'),
            );
            return redirect()->back();
        }
        $shippingMethod->delete();
        return redirect()->route('admin.shipping-methods.index');
    }

    public function syncZones(ShippingMethodSyncZonesRequest $request, ShippingMethod $shippingMethod) {
        // dd('www');
        $duplicatedMeta = DomesticZoneMeta::whereIntegerInRaw('domestic_zone_id', $request->get('domesticZones'))
            ->get()
            ->map(fn($d) => "$d->related_model::$d->related_model_id")
            ->duplicates();
        if ($duplicatedMeta->isNotEmpty()) return back()->with("danger", __('admin.shippingMethods.duplicated-zones'));
        $shippingMethod->domesticZones()->sync($request->get('domesticZones') ?? []);
        Alert::success('success', __('admin.shippingMethods.messages.related-domestic-zones-synced'));
        return back();
    }
}
