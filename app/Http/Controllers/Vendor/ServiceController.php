<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Service;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use App\Models\ServiceClass;
use Illuminate\Http\Request;
use App\Exports\ServicesExport;
use App\Models\ServiceQuantity;
use App\Events\Admin\Service\Modify;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VendorServicesExport;
use App\Http\Requests\Vendor\CreateServiceRequest;
use App\Models\ServiceWarehouseStock;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Vendor\ServiceRequest;
use App\Services\Images\ServiceImageService;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Vendor\ServiceRepository;
use App\Http\Requests\Vendor\UpdateServiceRequest;
use App\Http\Resources\Vendor\ServiceTableResource;
use App\Models\City;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderService;
use App\Models\OrderServiceDetail;
use App\Models\PostHarvestServicesDepartment;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    private $serviceRepository;
    private $serviceImageService;
    private $view;

    public function __construct(
        ServiceRepository $serviceRepository,
        ServiceImageService $serviceImageService
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->serviceImageService = $serviceImageService;
        $this->view = 'vendor/services';
    }

    public function index(Request $request)
    {
        return view(
                $this->view."/index",
                ['services' => $this->serviceRepository->getServicesPaginated(10, 'desc',$request),'request'=>$request]
            );
    }

    public function create()
    {
        $data['main_categories']  = $this->getMainCategoriesForSelect();
        $data['cities'] = City::select('id','name')->active()->get();
        return view($this->view.'/create',$data);
    }

    public function store(CreateServiceRequest $request)
    {
        $data = $request->all();
        $service = $this->serviceRepository->store($data);
        if ($service) $this->serviceImageService->handleImages($service, true);
        return redirect(route('vendor.services.index'))
                ->with(['success' => trans('admin.services.messages.created_successfully_title')]);
    }

    public function show($id)
    {
        $data['row']=$this->serviceRepository->find($id,['images', 'vendor.owner','category']);
        return view($this->view.'/show',$data);
    }

    public function edit($id)
    {
        $data['row']= $this->serviceRepository->find($id);
        $data['main_categories']  = $this->getMainCategoriesForSelect();
        $data['cities'] = City::select('id','name')->active()->get();
        return view($this->view.'/edit',$data);
    }

    public function update(UpdateServiceRequest $request,$id)
    {
        $data = $request->all();
        $service = $this->serviceRepository->update($data,$id);
        if ($service) {
            $this->serviceImageService->handleImages($service);
        }

        return redirect()->route('vendor.services.index')->with(['success' => trans('admin.services.messages.updated_successfully_title')]);
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if(!$service) return back();

        if (OrderServiceDetail::where('service_id', $id)->count()){
            Alert::error('خطأ', 'يوجد عمليات بيع لهذا المنتج فـ لا يمكن حذفه');
            return back();
        }

        $this->serviceRepository->delete($id);
        return redirect()->route('vendor.services.index')->with(['success' => trans('admin.services.messages.deleted_successfully_title')]);
    }

    public function getFields(PostHarvestServicesDepartment $category)
    {
        try {
            $fields = $category->post_harvest_services_department_fields()->where(['status' => 'active', 'depends_on_price' => true])->get()->toArray();
            return response()->json($fields);
        } catch (\Exception $e) {
            Log::error('Error retrieving fields for category: '.$e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    private function activeCategories() {
        return PostHarvestServicesDepartment::where('status','active')
            ->select('name','id')->get();
    }

    private function getMainCategoriesForSelect() : array {
        return $this->addSelectOptionToCategoriesOptions($this->activeCategories());
    }

    private function addSelectOptionToCategoriesOptions(Collection $categories) : array {
        return $categories->pluck('name', 'id')->toArray();
        $option = new PostHarvestServicesDepartment([
            'name' => [
                "ar" => __('admin.select-option', [], 'ar'),
                "en" => __('admin.select-option', [], 'ar')
            ]
        ]);
        $categories->prepend($option);
        return $categories->pluck('name', 'id')->toArray();
    }

    public function excel(Request $request)
    {

        return Excel::download(new VendorServicesExport($request), 'services '.date('d-m-Y').'-'.Str::random(1).'.xlsx');
    }

}
