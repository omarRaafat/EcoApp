<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LineShippingPriceRequest;
use App\Models\City;
use App\Models\LineShippingPrice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LineShippingPriceController extends Controller
{
    /**
     * @return View
     */
    public function index(Request $request): View
    {
        $lineShippingPrices = LineShippingPrice::query()->paginate(20);
        return view('admin.line_shipping_price.index' , get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $line = new LineShippingPrice();
        $cities = City::query()->get();
        return view('admin.line_shipping_price.create' , get_defined_vars());
    }

    /**
     * @param   LineShippingPriceRequest $request
     * @return  RedirectResponse
     */
    public function store(LineShippingPriceRequest $request): RedirectResponse
    {
        try {
            // $this->checkCityExist($request->city_id , $request->city_to_id);
            $line = new LineShippingPrice();

            $this->process($line, $request);

            Alert::success(__('admin.success'), __('admin.create_success'));
        } catch (Exception $e) {
            Alert::success('error', $e->getMessage());
        }

        return back();
    }

    /**
     * @param   int     $id
     * @return  View
     */
    public function edit(int $id): View
    {
        $cities = City::query()->get();
        $line = LineShippingPrice::query()->findOrFail($id);
        return view('admin.line_shipping_price.edit' , get_defined_vars());
    }

    /**
     * @param   LineShippingPriceRequest    $request
     * @param   int                         $id
     * @return  RedirectResponse
     */
    public function update(LineShippingPriceRequest $request, int $id): RedirectResponse
    {
        try {
            $item = LineShippingPrice::query()->findOrFail($id);
            // $this->checkCityExist($request->city_id , $request->city_to_id , $item);
            $this->process($item, $request);
            Alert::success(__('admin.success'), __('admin.update_success'));
        } catch (Exception $e) {
            Alert::success('error', $e->getMessage());
        }

        return back();
    }

    /**
     * @param   int $id
     * @return  RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try{
            $item = LineShippingPrice::query()->find($id);
            $item->delete();
            Alert::success(__('admin.success'), __('admin.delete_success'));
        } catch (Exception $ex) {
            Alert::success('error', $ex->getMessage());
        }

        return back();
    }

    /**
     * Create / update process
     *
     * @param  LineShippingPrice         $item
     * @param  LineShippingPriceRequest  $request
     *
     * @return LineShippingPrice
     */
    protected function process(LineShippingPrice $item, LineShippingPriceRequest $request): LineShippingPrice
    {
        $item->city_id      = $request->city_id;
        $item->city_to_id   = $request->city_to_id;
        $item->dyna         = $request->dyna;
        $item->lorry        = $request->lorry;
        $item->truck        = $request->truck;
        $item->save();

        return $item;
    }

    // public function checkCityExist(int $city_id ,int $city_to_id ,LineShippingPrice $item = null){
    //     // dd($city_id , $city_to_id , $item);
    //     $check_exist_city = LineShippingPrice::where(function($q) use($city_id , $city_to_id) {
    //         $q->where('city_id' , $city_id)->where('city_to_id' , $city_to_id);
    //     })->orWhere(function($q) use($city_id , $city_to_id) {
    //         $q->where('city_id' ,  $city_to_id)->where('city_to_id' , $city_id);
    //     })->when($item , function($q) use($item){
    //         $q->where('id' , '<>' , $item->id);
    //     })->first();
    //     if($check_exist_city){
    //         Alert::success('error', 'المدن موجوده بالفعل');
    //         return back();

    //     }
        
    // }
}
