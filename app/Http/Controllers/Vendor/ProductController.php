<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use App\Models\ProductClass;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use App\Models\ProductQuantity;
use App\Events\Admin\Product\Modify;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VendorProductsExport;
use App\Models\ProductWarehouseStock;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Vendor\ProductRequest;
use App\Services\Images\ProductImageService;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Vendor\ProductRepository;
use App\Http\Requests\Vendor\UpdateProductRequest;
use App\Http\Resources\Vendor\ProductTableResource;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderProduct;

class ProductController extends Controller
{
    private $productRepository;
    private $productImageService;
    private $view;

    public function __construct(
        ProductRepository $productRepository,
        ProductImageService $productImageService
    ) {
        $this->productRepository = $productRepository;
        $this->productImageService = $productImageService;
        $this->view = 'vendor/products';
    }
    // public function index()
    // {
    //     $data['products_count']=$this->productRepository->countAll();
    //     return view($this->view.'/index',$data);
    // }

    public function index(Request $request)
    {
       
        return view(
                $this->view."/index",
                ['products' => $this->productRepository->getProductsPaginated(10, 'desc',$request),'request'=>$request]
            );
    }

    public function productForTable(Request $request)
    {
        $products=$this->productRepository->getAllWithPagination($request,$request->paginate);
        return ProductTableResource::collection($products);
    }

    public function create()
    {
        $data['main_categories']  = $this->getMainCategoriesForSelect();
        $data['sub_categories']   = old('category_id') ? $this->getSubCategoriesForSelect(old('category_id')) : [];
        $data['final_categories'] = old('sub_category_id') ? $this->getSubCategoriesForSelect(old('sub_category_id')) : [];
        $data['quantity_types'] = ProductQuantity::getProductQuantityTypes();
        $data['types'] = ProductClass::getProductClasses();
        return view($this->view.'/create',$data);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $product = $this->productRepository->store($data);
        $this->productImageService->handleImages($product);
//        event(new Product\Created($product));
        return redirect('vendor/products');
    }

    public function show($id)
    {
        $data['row']=$this->productRepository->find($id,['images', 'vendor.owner', 'reviews', 'quantity_type', 'type', 'category', 'subCategory', 'finalSubCategory']);
        $data['warehouses'] = Warehouse::query()->where('vendor_id' , auth()->user()->vendor_id )->available()->get();
        return view($this->view.'/show',$data);
    }

    public function edit($id)
    {
        $data['row']= $this->productRepository->find($id);
        $data['main_categories']  = $this->getMainCategoriesForSelect();
        $data['sub_categories']   = $this->getSubCategoriesForSelect($data['row']->category_id);
        $data['final_categories'] = $this->getSubCategoriesForSelect($data['row']->sub_category_id, true);
        $data['quantity_types'] = ProductQuantity::getProductQuantityTypes();
        $data['types'] = ProductClass::getProductClasses();
        return view($this->view.'/edit',$data);
    }

    public function update(UpdateProductRequest $request,$id)
    {
        $data = $request->all();
        $product = $this->productRepository->update($data,$id);
        $this->productImageService->handleImages($product);
        return redirect('vendor/products');
    }

    public function getSubCategories(Request $request)
    {
        return $this->addSelectOptionToCategoriesOptins($this->activeCategories($request->parent_id));
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if(!$product) return back();

        if (OrderProduct::where('product_id', $id)->count()){
            Alert::error('خطأ', 'يوجد عمليات بيع لهذا المنتج فـ لا يمكن حذفه');
        }
        $this->productRepository->delete($id);
        return redirect('vendor/products');
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

    private function getSubCategoriesForSelect($parentId,  $isFinalCtg = false) : array {
        return $this->addSelectOptionToCategoriesOptins($this->activeCategories($parentId, $isFinalCtg));
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

    public function updateStock($product_id)
    {
        if(request()->get('stock') == 0){
            return response()->json(['status'=> false,'message' => "لتصفية المخزون يجب ضغط على ايقونة الحذف"])->setStatusCode(400);             
        }

        $validator = Validator::make(request()->all(), [
            'warehouse_id' => "required|exists:warehouses,id",
            'stock' => 'required|numeric|min:1|max:10000000'
        ]);
        
        if ($validator->fails()) {
            if(request()->get('isJson')){
                return response()->json(['status'=> false,'message' => $validator->errors()->first()])->setStatusCode(400);             
            }else{
                return back()->withErrors($validator->errors()->first());
            }
        } 

        $product = Product::find($product_id);
        $warehouse = Warehouse::available()->where('vendor_id' , auth()->user()->vendor_id)->find(request()->get('warehouse_id'));

        if(!$product || !$warehouse){
            if(request()->get('isJson')){
                return response()->json(['status'=> false,'message' => 'منتج غير متوفر!'])->setStatusCode(400);             
            }else{
                return back()->withErrors("منتج غير متوفر");
            }
        }

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


    public function excel(Request $request)
    {   
        
        return Excel::download(new VendorProductsExport($request), 'products '.date('d-m-Y').'-'.Str::random(1).'.xlsx');
    }

    public function deleteStock(int $id)
    {
        $ProductWarehouseStock = ProductWarehouseStock::query()->findOrFail($id);
        Warehouse::where('vendor_id' , auth()->user()->vendor_id)->findOrFail($ProductWarehouseStock->warehouse_id);
        $ProductWarehouseStock->delete();
        
        return back()->with("success", trans("admin.products.stock-deleted"));
    }

}
