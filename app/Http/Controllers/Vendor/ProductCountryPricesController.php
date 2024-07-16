<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\CreateCountryPriceRequest;
use App\Http\Requests\Vendor\UpdateCountryPriceRequest;
use App\Models\Country;
use App\Services\ProductCountryPricesService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductCountryPricesController extends Controller
{
    /**
     * Product Country Price Class Controller Constructor.
     *
     * @param ProductCountryPricesService $service
     */
    public function __construct(public ProductCountryPricesService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function index(Request $request, $productId)
    {
        $countriesPrices = $this->service->getAllCountriesPricesWithPagination($request, $productId);
        $breadcrumbParent = 'admin.products.edit';
        $breadcrumbParentUrl = route('vendor.products.edit',$productId);
        return view("vendor.countries_prices.index", compact('countriesPrices', 'breadcrumbParent', 'breadcrumbParentUrl'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\View
     */
    public function create(int $id)
    {
        $availableCountry = Country::select('id', 'name')->where('is_national', 0)->active()->get();
        $breadcrumbParent = 'admin.products.edit';
        $breadcrumbParentUrl = route('vendor.products.edit',$id);
        return view("vendor.countries_prices.create", compact('availableCountry', 'breadcrumbParent', 'breadcrumbParentUrl'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCountryRequest $request
     * @return Redirect
     */
    public function store(CreateCountryPriceRequest $request)
    {
        $result = $this->service->createCountryPrice($request->validated());
        if($result["success"] == TRUE)
        {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route('vendor.products.edit',$result['product_id']);
        }
        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Edit the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\View
     */
    public function edit(int $id)
    {
        $countryPrice = $this->service->getCountryPriceUsingID($id);

        $availableCountry = Country::whereDoesntHave('countryPrices',function($q) use($countryPrice){
            $q->where('country_id','!=',$countryPrice->country_id)->where('product_id',$countryPrice->product_id);
            })->select('id', 'name')->where('is_national', 0)->active()->get();

        $breadcrumbParent = 'admin.countries_prices.list';
        $breadcrumbParentUrl = route('vendor.products.prices.list',$countryPrice->product_id);
        return view("vendor.countries_prices.edit", compact('countryPrice', 'availableCountry', 'breadcrumbParent', 'breadcrumbParentUrl'));
    }

    /**
     * Update resource in storage using ID
     *
     * @param UpdateCountryRequest $request
     * @param int $id
     * @return Redirect
     */
    public function update(UpdateCountryPriceRequest $request, int $id)
    {
        $result = $this->service->updateCountryPrice($id, $request->validated());
        if($result["success"] == TRUE)
        {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route('vendor.products.prices.list', ['id' => $result['product_id']]);
        }
        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    /**
     * Delete Product Class Using ID.
     *
     * @param int $id
     * @return Redirect
     */
    public function destroy(int $id)
    {
        $result = $this->service->deleteCountryPrice($id);
        if($result["success"] == TRUE)
        {
            Alert::success($result["title"], $result["body"]);
        }
        else
        {
            Alert::error($result["title"], $result["body"]);
        }
        return redirect()->route('vendor.products.prices.list', ['id' => $result['product_id']]);
    }
}
