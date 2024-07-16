<?php
namespace App\Http\Controllers\Admin;
use App\Events\Admin\Product\Approve;
use App\Events\Admin\Product\Modify;
use App\Events\Admin\Product\Reject;
use App\Exports\OrdersExport;
use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ProductQuantity;
use App\Models\ProductTemp;
use App\Models\ProductWarehouseStock;
use App\Models\Vendor;
use App\Models\Warehouse;
use App\Repositories\Admin\ProductRepository as ProductRepository;
use App\Services\Images\ProductImageService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\ProductImage;
use App\Models\ProductNote;

class ProductController extends Controller
{
    private $productRepository;
    private $productImageService;

    public function __construct(ProductRepository $productRepository, ProductImageService $productImageService) {
        $this->productRepository = $productRepository;
        $this->productImageService = $productImageService;
    }

    public function index(Request $request)
    {
        if($request->action == "exportExcel"){
            return Excel::download(new ProductsExport($request), 'products.xlsx');
        }

        return view(
            "admin.products.index",
            [
                'products' => $this->productRepository->getProductsPaginated(request()),
                'vendors' => Vendor::available()
                    ->with('user:id,name,email')
                    ->select('id','name','user_id')
                    ->get()
            ]
        );
    }

    public function create()
    {

        try {
            $breadcrumbParent = 'admin.products.index';
            $breadcrumbParentUrl = route('admin.products.index');
            $main_categories = $this->getMainCategoriesForSelect();
            $sub_categories = old('category_id') ? $this->getSubCategoriesForSelect(old('category_id')) : [];
            $final_categories = old('sub_category_id') ? $this->getSubCategoriesForSelect(old('sub_category_id')) : [];
            $quantity_types = ProductQuantity::getProductQuantityTypes();
            $types = ProductClass::getProductClasses();
            $vendors = Vendor::select('name', 'id','is_international')->whereJsonContains('services', 'selling_products')->get();

            return view("admin.products.create", compact('main_categories', 'sub_categories', 'final_categories', 'quantity_types', 'types', 'vendors', "breadcrumbParent", "breadcrumbParentUrl"));
        } catch (Exception $e) {
            Alert::error('', $e->getMessage());
            return redirect()->back();
            return redirect()->route('admin.home');
        }
    }


    public function store(CreateProductRequest $request)
    {
        try {
            $request->merge(['is_active' => 1]);
            $data = $request->all();
            $product = $this->productRepository->store_product($data);
            if ($product) $this->productImageService->handleImages($product, true);
            return redirect(route('admin.products.index'))
                ->with(['success' => trans('admin.products.messages.created_successfully_title')]);
        } catch (Exception $e) {
            Alert::error('System Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($product_id)
    {
        try {
            $data['row'] = $this->productRepository->show(
                $product_id, [
                    'images', 'vendor.owner', 'reviews', 'quantity_type', 'type', 'category',
                    'subCategory', 'finalSubCategory', 'temp',
                    'warehouseStock' => fn($stock) => $stock->with(["warehouse" => fn($w) => $w->withTrashed()])
                ]
            );

            $data['warehouses'] = Warehouse::where('vendor_id' , $data['row']->vendor_id)->get();

            if (isset($data['row'])) {
                $data['breadcrumbParent'] = 'admin.products.index';
                $data['breadcrumbParentUrl'] = route('admin.products.index');
                return view("admin.products.show", $data);
            }

        } catch (Exception $e) {
            return redirect()->route('admin.home');
        }
    }

    public function edit($id)
    {
        try {
            $data['row'] = $this->productRepository->show($id,['vendor:id,is_international']);
            $data['main_categories'] = $this->getMainCategoriesForSelect();
            $data['sub_categories'] = $this->getSubCategoriesForSelect($data['row']->category_id);
            $data['final_categories'] = $this->getSubCategoriesForSelect($data['row']->sub_category_id,true);
            $data['quantity_types'] = ProductQuantity::getProductQuantityTypes();
            $data['types'] = ProductClass::getProductClasses();
            $data['vendors'] =  Vendor::select('name', 'id','is_international')->get();

            if (isset($data['row'])) {
                $data['breadcrumbParent'] = 'admin.products.index';
                $data['breadcrumbParentUrl'] = route('admin.products.index');
                return view("admin.products.edit", $data);
            }
        } catch (Exception $e) {
            return redirect()->route('admin.home');
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
      //  try {
            // $request->merge(['desc' => ['ar' => $request->desc_ar, 'en' => $request->desc_en]]);
            $data = $request->all();
            $product = $this->productRepository->update_product($data, $id);

            if ($product) {
                $this->productImageService->handleImages($product);
                event(new Modify($product));
                return redirect()->route('admin.products.index')->with(['success' => trans('admin.products.messages.updated_successfully_title')]);
            }

       /* }catch (Exception $e) {
            Alert::error('', $e->getMessage());
            return redirect()->back();
            return redirect()->route('admin.home');
        }*/
    }


    public function destroy($id)
    {
        if (!$product_check = $this->productRepository->show($id))
            return redirect()->route('admin.products.index');

        if (Product::query()->find($id)->orderProducts()->where('product_id', $id)->exists()){
            Alert::error('خطأ', 'يوجد عمليات بيع لهذا المنتج فـ لا يمكن حذفه');
            return back();
        }


        try {
            $product = $this->productRepository->destroy_product($id);
            return redirect()->route('admin.products.index')->with(['success' => trans('admin.products.messages.deleted_successfully_title')]);
        } catch (Exception $e) {
            return redirect()->route('admin.home');
        }
    }

    public function getSubCategories(Request $request)
    {
        return $this->addSelectOptionToCategoriesOptins($this->activeCategories($request->parent_id));
    }

    public function acceptProduct(Product $product) {

        if ($product->status != 'accepted'){
            $product->update(['status' => 'accepted', 'is_active' => 1, 'is_visible' => 1]);
            ProductNote::where('product_id',$product->id)->delete();

            if($product->square_image_temp){
                $product->clearMediaCollection(Product::mediaCollectionName);
                Media::where(['model_id' => $product->id , 'model_type'=>'App\Models\Product', 'collection_name' => Product::mediaTempCollectionName])->update(['collection_name' => Product::mediaCollectionName]);
                $product->clearMediaCollection(Product::mediaTempCollectionName);
            }
            if($product->clearance_cert_media_temp){
                $product->clearMediaCollection(Product::clearanceCertCollectionName);
                Media::where(['model_id' => $product->id , 'model_type'=>'App\Models\Product', 'collection_name' => Product::clearanceCertTempCollectionName])->update(['collection_name' => Product::clearanceCertCollectionName]);
                $product->clearMediaCollection(Product::clearanceCertTempCollectionName);
            }
            ProductImage::where('product_id',$product->id)->where('is_accept',0)->update([
                'is_accept'=>1
            ]);

            event(new Approve($product));
        }else if ($product->status != 'pending'){
            $product->update(['status' => 'pending', 'is_active' => 0]);
            event(new Reject($product));
        }
        return back()->with('success', __('admin.products.messages.status_changed_successfully_title'));
    }

    public function acceptUpdate(Product $product)
    {
        if($product->temp){
            $this->productRepository->updateProductAfterAccept($product);
            if($product->square_image_temp){
                $product->clearMediaCollection(Product::mediaCollectionName);
                Media::where(['model_id' => $product->id , 'model_type'=>'App\Models\Product', 'collection_name' => Product::mediaTempCollectionName])->update(['collection_name' => Product::mediaCollectionName]);
                $product->clearMediaCollection(Product::mediaTempCollectionName);
            }
            if($product->clearance_cert_media_temp){
                $product->clearMediaCollection(Product::clearanceCertCollectionName);
                Media::where(['model_id' => $product->id , 'model_type'=>'App\Models\Product', 'collection_name' => Product::clearanceCertTempCollectionName])->update(['collection_name' => Product::clearanceCertCollectionName]);
                $product->clearMediaCollection(Product::clearanceCertTempCollectionName);
            }

            $product->temp()->delete();
        }
        ProductImage::where('product_id',$product->id)->where('is_accept',0)->update([
            'is_accept'=>1
        ]);
        return back()->with('success', __('admin.products.messages.status_changed_successfully_title'));
    }

    public function approve(Product $product): \Illuminate\Http\JsonResponse
    {
        $product->status = 'accepted';
        $product->save();
        if($product->square_image_temp){
            $product->clearMediaCollection(Product::mediaCollectionName);
            Media::where(['model_id' => $product->id , 'model_type'=>'App\Models\Product', 'collection_name' => Product::mediaTempCollectionName])->update(['collection_name' => Product::mediaCollectionName]);
            $product->clearMediaCollection(Product::mediaTempCollectionName);
        }
        if($product->clearance_cert_media_temp){
            $product->clearMediaCollection(Product::clearanceCertCollectionName);
            Media::where(['model_id' => $product->id , 'model_type'=>'App\Models\Product', 'collection_name' => Product::clearanceCertTempCollectionName])->update(['collection_name' => Product::clearanceCertCollectionName]);
            $product->clearMediaCollection(Product::clearanceCertTempCollectionName);
        }
        ProductImage::where('product_id',$product->id)->where('is_accept',0)->update([
            'is_accept'=>1
        ]);
        event(new Approve($product));
        return response()->json(['status' => 'success','data' => $product->status,'message' => __('admin.products.messages.status_approved_successfully_title')],200);
    }

    public function refuseUpdate(Product $product,Request $request)
    {
        if($product->temp){
            $product->temp()->update(['approval'=>ProductTemp::REFUSED,'note'=>$request->note]);
        }
        return back()->with('success', __('admin.products.messages.status_changed_successfully_title'));
    }

    public function refuseDelete(Product $product)
    {
        if($product->temp){
            $product->temp()->update(['approval'=>ProductTemp::PENDING,'note'=>NULL]);
        }
        return back()->with('success', __('admin.products.messages.status_changed_successfully_title'));
    }

    public function reject(Product $product,Request $request)
    {
        ProductNote::updateOrCreate([
            'product_id'=>$product->id,
            ],[
            'note'=>$request->note
        ]);
        return back()->with('success', __('admin.products.messages.status_changed_successfully_title'));
    }

    public function printBarcode(Product $product) {
        return view("admin.products.print-barcode", ['product' => $product]);
    }

    public function updateStock(Product $product) {
        $this->validate(request(), [
            'warehouse_id' => "required|exists:warehouses,id",
            'stock' => 'required|numeric|min:1|max:10000000'
        ], [], [
            'warehouse_id' => trans("admin.products.warehouse-name"),
            'stock' => trans("admin.products.stock"),
        ]);
        $warehouse = Warehouse::find(request()->get('warehouse_id'));
        ProductWarehouseStock::updateOrCreate(
            ['product_id' => $product->id, 'warehouse_id' => $warehouse->id],
            ['stock' => request()->get('stock')]
        );
        $product->update(["stock" => $product->warehouseStock()->sum('stock')]);
        if(request()->get('isJson')){
            return response(['message'=>trans("admin.products.stock-updated", ['warehouse' => $warehouse->getTranslation("name", "ar")]) ]);
        }
        return back()->with("success", trans("admin.products.stock-updated", ['warehouse' => $warehouse->getTranslation("name", "ar")]));
    }

    public function deleteStock(int $id)
    {
        ProductWarehouseStock::query()->find($id)->delete();
        return back()->with("success", trans("admin.products.stock-deleted"));
    }

    private function activeCategories($parentId = null, $isFinalCtg = false) {
        return Category::active()
            ->when($parentId ,fn($q) => $q->where('parent_id', $parentId))
            ->when(!$parentId ,fn($q) => $q->whereNull('parent_id'))
            ->when($isFinalCtg ,fn($q) => $q->whereNotNull('parent_id'))
            ->select('name','id')->get();
    }

    private function getMainCategoriesForSelect() : array {
        return $this->addSelectOptionToCategoriesOptins($this->activeCategories());
    }

    private function getSubCategoriesForSelect($parentId, $isFinalCtg = false) : array {
        return $this->addSelectOptionToCategoriesOptins($this->activeCategories($parentId,$isFinalCtg));
    }

    private function addSelectOptionToCategoriesOptins(Collection $categories) : array {
        return $categories->pluck('name', 'id')->toArray();
        $option = new Category([
            'name' => [
                "ar" => __('admin.select-option', [], 'ar'),
                "en" => __('admin.select-option', [], 'ar')
            ]
        ]);
        $categories->prepend($option);
        return $categories->pluck('name', 'id')->toArray();
    }




    #منتجات شارفت على الإنتهاء
    public function almostOutOfStock(Request $request){
        if($request->action == "exportExcel"){
            $request['function'] = 'almostOutOfStock';
            return Excel::download(new ProductsExport($request), 'products-almostOutOfStock.xlsx');
        }

        $products = Product::where('stock','<=',10)->where('stock','>',0)
        ->search($request->search)
        ->when($request->vendor_id,fn($q) => $q->where('vendor_id', $request->vendor_id))
        ->latest()->paginate(50);

        $vendors = Vendor::available()->get();

        return view("admin.products.index", compact('products','vendors'));
    }

    #منتجات نفذت من المخزون
    public function outOfStock(Request $request){
        if($request->action == "exportExcel"){
            $request['function'] = 'outOfStock';
            return Excel::download(new ProductsExport($request), 'products-outOfStock.xlsx');
        }

        $products = Product::where('stock','<=',0)
        ->search($request->search)
        ->when($request->vendor_id,fn($q) => $q->where('vendor_id', $request->vendor_id))
        ->latest()->paginate(50);
        $vendors = Vendor::available()->get();

        return view("admin.products.index", compact('products','vendors'));
    }

    #منتجات محذوفة
    public function deleted(Request $request){
        if($request->action == "exportExcel"){
            $request['function'] = 'deleted';
            return Excel::download(new ProductsExport($request), 'products-deleted.xlsx');
        }

        $products = Product::onlyTrashed()
        ->search($request->search)
        ->when($request->vendor_id,fn($q) => $q->where('vendor_id', $request->vendor_id))
        ->latest()->paginate(50);
        $vendors = Vendor::available()->get();

        
        return view("admin.products.index", compact('products','vendors'));
    }

    public function refuseUpdate2(Product $product,Request $request)
    {
        if($product->note){
            $product->note()->update(['note'=>$request->note]);
        }
        return back()->with('success', __('admin.products.messages.status_changed_successfully_title'));
    }

    public function refuseDelete2(Product $product)
    {
        if($product->note){
            $product->note()->update(['note'=>NULL]);
        }
        return back()->with('success', __('admin.products.messages.status_changed_successfully_title'));
    }


}
