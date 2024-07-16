<?php


namespace App\Repositories\Admin;

use App\Enums\SettingEnum;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductPrice;
use App\Models\Setting;
use App\Repositories\Api\BaseRepository;
use Carbon\Carbon;

class ProductRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */


    public function index()
    {
        return $this->model->paginate(15);
    }

    public function getProductsPaginated($request = null, int $perPage = 10, $sort = 'desc')
    {
        $sort = strtolower($sort);
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';
        $search = $request->has('search') ? $request->search : null;
        return $this->model->with('category','quantity_type','vendor','note','temp','media')
            ->when(
                $search,
                fn($q) => $q->where(
                    fn($subQ) => $subQ->where('name->ar', 'like', "%$search%")
                        ->orWhere('name->en', 'like', "%$search%")
                )
            )
            ->when($request->vendor_id,fn($q) => $q->where('vendor_id', $request->vendor_id)
            )
            ->when(
                $request->temp==1,
                fn($q) => $q->has('temp')
            )
            ->when(
                !$request->temp && $request->has('status') != 'pending',
                fn($q) => $q->whereDoesntHave('temp')
            )
            ->when(
                $request->has('status') != 'pending',
                fn($q) => $q->accepted()
            )
            ->when(
                $request->has('active_status') && $request->active_status != 'all',
                fn($q) => $q->where('is_active', $request->active_status == "active" ? 1 : 0)
            )->when(
                $request->get('status') == 'pending',
                fn($q) => $q->where('status', $request->status)
            )
            ->when(
                $request->get('status') == 'pending' && $request->filled('note') &&  $request->get('note') == 1,
                fn($q) => $q->whereHas('note', function($nq){
                        $nq->where('note' , '!=' , NULL);
                })
            )
            ->when(
                $request->get('status') == 'pending' && $request->filled('note') &&  $request->get('note') == 0,
                fn($q) => $q->whereDoesntHave('note')
            )
            ->when(
                $request->has('created_date'),
                function ($q) use ($request) {
                    $dateRange = explode(" to " ,$request->created_date);
                    if (count($dateRange) == 2) {
                        $dateFrom = Carbon::parse($dateRange[0])->format("Y-m-d");
                        $dateTo = Carbon::parse($dateRange[1])->format("Y-m-d");
                        $dateFrom = $dateFrom ." 00:00:00";
                        $dateTo = $dateTo ." 23:59:59";
                        $q->when(
                            $dateFrom && $dateTo,
                            fn($subQ) => $subQ->where('created_at', '>=', $dateFrom)->where('created_at', '<=', $dateTo)
                        );
                    }
                }
            )
            ->when( $request->get('status') != 'pending' && $request->filled('note') && $request->get('note') == 1  , fn($qn) => 
                $qn->whereHas('productTemp' , function($sqn){
                    $sqn->where('note', '!=', null);
                })
            )
            ->when( $request->get('status') != 'pending' && $request->filled('note') && $request->get('note') == 0  , fn($qn) => 
            $qn->whereHas('productTemp' , function($sqn){
                $sqn->whereNote(NULL);
            })
        )
            ->orderBy('id', $sort)
            ->paginate($perPage);
    }

    public function show($product_id, array $relations = [])
    {
        $product = $this->model->with($relations)->findOrFail($product_id);
        $product->ar = ['name' => $product->getTranslation('name', 'ar'), 'desc' => $product->getTranslation('desc', 'ar')];
        $product->en = ['name' => $product->getTranslation('name', 'en'), 'desc' => $product->getTranslation('desc', 'en')];
        $reviews_count = $product->reviews()->count();
        $product->reviews_count = ($reviews_count > 0) ? $reviews_count : 1;
        $product->new_images=[];
        if($product->temp)
        {
            $product->new_images=array_diff($product->temp->images_array(),$product->images()->pluck('id')->toArray());
        }
        return $product;
    }

    public function store_product($data_request)
    {
        $data_request['status'] = 'accepted';
        $data_request['is_visible'] = 1;
        unset($data_request['image']);
        $product = $this->model->create($data_request);

        if (isset($data_request['images_array']) && isset($data_request['images_array'][0])) {
            $images = explode(',', $data_request['images_array'][0]);
            foreach ($images as $image_id)
                ProductImage::where('id', $image_id)->update(['product_id' => $product->id]);
        }
        return $product;
    }

    public function update_product($data_request, $id)
    {
        $row = $this->model->findOrFail($id);
        unset($data_request['image']);
        $row->update($data_request);
        if (isset($data_request['images_array']) && isset($data_request['images_array'][0])) {
            $images = explode(',', $data_request['images_array'][0]);
            ProductImage::whereIn('id', $images)->update(['product_id' => $row->id]);

            if(request()->deleted_images_array){
                $arryIds = explode(',',trim(request()->deleted_images_array,','));
                $deletesProductImage = ProductImage::where('product_id',$row->id)->whereIn('id', $arryIds)->get();
                foreach ($deletesProductImage as $key => $productImage) {
                    $productImage->clearMediaCollection(ProductImage::mediaCollectionName);
                }

                $row->images()->whereIn('id', $arryIds)->delete();
            }
        }
        return $row;

    }

    public function destroy_product($id)
    {
        $product = $this->model->find($id);
        if ($product == NULL)
            return false;
        $product->delete();
    }

    public function getCategoryForSelect($level = 1, $parent_id = null)
    {
        $categories = Category::where('parent_id', $parent_id)->pluck('name', 'id')->toArray();
        return $categories;
    }

    function model(): string
    {
        return "App\Models\Product";
    }

    public function calculateRate(int $product_id)
    {
        $product = $this->model->findOrFail($product_id);

        $rate = $product->approvedReviews()->avg('rate');
        $count = $product->approvedReviews()->count();

        $product->rate = $rate ?? 0;
        $product->reviews_conunt = $count;
        $product->save();
    }

    public function updateProductAfterAccept($product)
    {
        //Translated Data
        foreach (\Config::get('app.locales') as $locale) {
            if($product->getTranslation('name',$locale) != $product->temp->getTranslation('name',$locale)){
                $product->setTranslations('name', [$locale=>$product->temp->getTranslation('name',$locale)]);
            }
            if($product->getTranslation('desc',$locale) != $product->temp->getTranslation('desc',$locale)){
                $product->setTranslations('desc', [$locale=>$product->temp->getTranslation('desc',$locale)]);
            }
        }

        //Core Data
        $updated_data=json_decode($product->temp->updated_data,true);
        unset($updated_data['image']);
        unset($updated_data['clearance_cert']);
        $product->update($updated_data);

        //Images
        ProductImage::where('product_id',$product->id)->update(['product_id'=>null]);
        ProductImage::whereIn('id',$product->temp->images_array())->update(['product_id'=>$product->id]);
    }

}
