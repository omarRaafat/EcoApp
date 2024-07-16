<?php

namespace App\Services\Api;

use App\Models\Vendor;
use App\Repositories\Api\VendorRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VendorService
{
    /**
     * Vendor Service Constructor.
     *
     * @param Vendorepository $repository
     */
    public function __construct(public VendorRepository $repository) {}

    /**
     * Get Vendors.
     *
     * @return Collection
     */
    public function getAllVendors() : Model
    {
        return $this->repository->all();
    }

    /**
     * Get Vendors with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllVendorsWithPagination(int $perPage = 10) : LengthAwarePaginator
    {
        return $this->repository->all()->available()
                                ->where("is_active", true)
                                ->where("approval", "approved")
                                ->paginate($perPage);
    }

    /**
     * Get Vendors with pagination.
     *
     * @param integer $perPage
     * @return Array
     */
    public function getAllVendorsInfinityLoad(int $perPage = 10) : Array
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;

        $vendors = $this->repository->all()->available()
        ->where('is_active', true)             // Ensures the vendor is active
        ->where('approval', 'approved')        // Ensures the vendor is approved
        ->where(function ($query) {
            $query->whereHas('availableProducts')  // Ensures the vendor has available products
                ->orWhereHas('availableServices');  // Ensures the vendor has available services
        })
        ->when(!empty(request()->get('search')), function ($qr) {
            $qr->search(request()->get('search'));  // Applies search filter if present
        })
        ->when(!empty(request()->get('city_id')), function ($qr) {
            $qr->whereHas('warehousesReceive', function ($qr2) {
                $qr2->whereHas('cities', function ($qr3) {
                    $qr3->where('city_id', request()->get('city_id'));  // Filters by city if present
                });
            });
        });

       $count = $vendors->count();

       $vendors = $vendors->offset($offset)->take($perPage)->get();


        $next = ($page * $perPage) < $count;

        return [
            'vendors' => $vendors,
            'next' => $next,
        ];

    }
    public function site_map() : array
    {

        $vendors_data  = [];
        $vendors = $this->repository->all()->available()->get();
        foreach ($vendors as $vendor)
        {
            $vendors_data[]=
                [
                    'name' => env('WEBSITE_BASE_URL').'/vendors/'. $vendor->getTranslation("name", "ar"),
                    'link' => env('WEBSITE_BASE_URL').'/vendors/'. $vendor->id .'/'.$vendor->getTranslation("name", "ar")
                ];

        }

        return $vendors_data;
    }

    /**
     * Get Vendor using ID.
     *
     * @param integer $id
     * @return Vendor
     */
    public function getVendorUsingID(int $id) : Vendor
    {
        return $this->repository->all()->available()->where('id',$id)->first();
    }

    public function updateVendor(Request $request,$id)
    {
        $request=$request->merge([
            'crd' => Carbon::parse($request->crd)->format('Y-m-d')
        ])->all();
//        if ($request['cr'] && json_decode($request['cr'])->data != null) {
//            $request['cr']=json_decode($request['cr'])->data;
//        }
//        if ($request['broc'] && json_decode($request['broc'])->data != null) {
//            $request['broc']=json_decode($request['broc'])->data;
//        }
//        if ($request['tax_certificate'] && json_decode($request['tax_certificate'])->data != null) {
//            $request['tax_certificate']=json_decode($request['tax_certificate'])->data;
//        }

//        if ($request['saudia_certificate'] && json_decode($request['saudia_certificate'])->data != null) {
//            $request['saudia_certificate']=json_decode($request['saudia_certificate'])->data;
//        }
//
//        if ($request['subscription_certificate'] && json_decode($request['subscription_certificate'])->data != null) {
//            $request['subscription_certificate']=json_decode($request['subscription_certificate'])->data;
//        }

//        if ($request['room_certificate'] && json_decode($request['room_certificate'])->data != null) {
//            $request['room_certificate']=json_decode($request['room_certificate'])->data;
//        }


        $vendor=$this->repository->getModelUsingID($id);
        $this->repository->update($request,$vendor);

    }
    /**
     * Get Vendor using ID.
     *
     * @param integer $id
     * @return Vendor
     */
    public function getVendorWithPaginatedProduct(int $id,int $perPage = 10) : vendor
    {
        $vendor = $this->getVendorUsingID($id);
        $products = $vendor->products()->available()->paginate($perPage);

        $vendor->products = $products;
        return $vendor;
    }

            /**
     * Get Products with pagination.
     *
     * @param integer $perPage
     * @return array
     */
    public function getAllProductsInfinityLoad(int $vendor_id,int $perPage = 10 ) : Array
    {
        $page = (request()->page ?? 1) ;
        $offset = ($page - 1) * $perPage;

        $vendor = $this->getVendorUsingID($vendor_id);
        $products = $vendor->products()->available();
        $count = $products->count();

        $products = $products->offset($offset)->take($perPage)->get();
        $vendor->products = $products;

        $next = ($page * $perPage) < $count;

        return [
            'vendor' => $vendor,
            'next' => $next,
        ];
    }

    public function checkAvilablity($id)
    {
        $vendor = $this->repository->getVendorIfAvailable($id);
        if($vendor == null)
            return false;
        return true;
    }

}
