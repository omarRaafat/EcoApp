<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\DomesticZone;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Enums\DomesticZone as DomesticZoneType;
use App\Http\Requests\Admin\Delivery\CreateDomesticZone;
use App\Http\Requests\Admin\Delivery\UpdateDomesticZone;
use App\Models\DomesticZoneMeta;

class DomesticZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : \Illuminate\Contracts\View\View
    {
        $collection = DomesticZone::withCount('domesticZoneMeta as cities_count')
            ->when(
                request()->has('search') && request()->get('search') != '',
                fn($q) => $q->where(
                    fn($nameQ) => $nameQ->where('name->ar', 'like', '%'. request()->get('search') .'%')
                        ->orWhere('name->en', 'like', '%'. request()->get('search') .'%')
                )
            )
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view("admin.domestic-zones.index", ['collection' => $collection]);
    }

    public function create()
    {
        return view("admin.domestic-zones.create", [
            'countries' => Country::active()->where('is_national', false)->select("name", "id")->get(),
            'cities' => Country::where('is_national', true)->with('cities')->first()->cities ?? [],
            'shippingType' => DomesticZoneType::getTypes(),
            'breadcrumbParent' => 'admin.domestic-zones.index',
            'breadcrumbParentUrl' => route('admin.domestic-zones.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateDomesticZone $request
     * @return Response
     */
    public function store(CreateDomesticZone $request) : \Illuminate\Http\RedirectResponse
    {
        $domesticZone = DomesticZone::create($this->requestToArray($request));
        $this->syncDomesticZoneMeta(
            $domesticZone,
            $request->get('type') == DomesticZoneType::INTERNATIONAL_TYPE ? $request->get('countries', []) : $request->get('cities', []),
            $request->get('type') == DomesticZoneType::INTERNATIONAL_TYPE ? Country::class : City::class
        );
        Alert::success(
            __('admin.delivery.domestic-zones.messages.success-title'),
            __('admin.delivery.domestic-zones.messages.created')
        );
        return redirect(route('admin.domestic-zones.show', ['domestic_zone' => $domesticZone]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) : \Illuminate\Contracts\View\View
    {
        $domesticZone = DomesticZone::with(['cities', 'countries'])->findOrFail($id);
        $deliveryFeeses = $domesticZone->deliveryFeeses()->paginate(10);

        return view("admin.domestic-zones.show", [
            'domesticZone' => $domesticZone,
            'deliveryFeeses' => $deliveryFeeses,
            'breadcrumbParent' => 'admin.domestic-zones.index',
            'breadcrumbParentUrl' => route('admin.domestic-zones.index')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) : \Illuminate\Contracts\View\View
    {
        $domesticZone = DomesticZone::with(['cities', 'countries', 'domesticZoneMeta'])->findOrFail($id);

        return view("admin.domestic-zones.edit", [
            'shippingType' => DomesticZoneType::getTypes(),
            'domesticZone' => $domesticZone,
            'selectedMeta' => $domesticZone->domesticZoneMeta->map(fn($e) => $e->related_model_id)->toArray(),
            'countries' => Country::active()->where('is_national', false)->select("name", "id")->get(),
            'cities' => Country::where('is_national', true)->with('cities')->first()->cities ?? [],
            'breadcrumbParent' => 'admin.domestic-zones.index',
            'breadcrumbParentUrl' => route('admin.domestic-zones.index')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDomesticZone $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDomesticZone $request, $id) : \Illuminate\Http\RedirectResponse
    {
        $domesticZone = DomesticZone::findOrFail($id);
        $domesticZone->update($this->requestToArray($request));
        DomesticZoneMeta::where('domestic_zone_id', $domesticZone->id)->delete();
        $this->syncDomesticZoneMeta(
            $domesticZone,
            $request->get('type') == DomesticZoneType::INTERNATIONAL_TYPE ? $request->get('countries', []) : $request->get('cities', []),
            $request->get('type') == DomesticZoneType::INTERNATIONAL_TYPE ? Country::class : City::class
        );
        Alert::success(
            __('admin.delivery.domestic-zones.messages.success-title'),
            __('admin.delivery.domestic-zones.messages.updated')
        );
        return redirect(route('admin.domestic-zones.show', ['domestic_zone' => $domesticZone]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) : \Illuminate\Http\RedirectResponse
    {
        $domesticZone = DomesticZone::findOrFail($id);
        $domesticZone->domesticZoneMeta()->delete();
        $domesticZone->deliveryFeeses()->delete();
        $domesticZone->delete();
        Alert::success(
            __('admin.delivery.domestic-zones.messages.success-title'),
            __('admin.delivery.domestic-zones.messages.deleted')
        );
        return redirect(route('admin.domestic-zones.index'));
    }

    private function requestToArray(CreateDomesticZone|UpdateDomesticZone $request) : array {
        $data = [
            'name'=>$request->get('name'),
            'type' => $request->get('type'),
            'days_from' => $request->get('days_from'),
            'days_to' => $request->get('days_to'),
        ];
        if ($request->get('type') == DomesticZoneType::NATIONAL_TYPE) {
            $data['additional_kilo_price']       = $request->get('additional_kilo_price');
            $data['delivery_fees']               = $request->get('delivery_fees');
            $data['delivery_fees_covered_kilos'] = $request->get('delivery_fees_covered_kilos');
            $data['fuelprice']                   = $request->get('fuelprice');
        }

        return $data;
    }

    private function syncDomesticZoneMeta(DomesticZone $domesticZone, array $meta, string $relatedModel) {
        $domesticZoneMetaData = collect([]);
        collect($meta)
        ->each(fn($m) => $domesticZoneMetaData->push([
            'created_at' => now(),
            'updated_at' => now(),
            'domestic_zone_id' => $domesticZone->id,
            "related_model" => $relatedModel,
            "related_model_id" => $m,
        ]));
        if ($domesticZoneMetaData->isNotEmpty()) DomesticZoneMeta::insert($domesticZoneMetaData->toArray());
    }
}
