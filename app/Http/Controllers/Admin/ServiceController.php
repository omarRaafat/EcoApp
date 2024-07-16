<?php
namespace App\Http\Controllers\Admin;
use App\Events\Admin\Service\Approve;
use App\Events\Admin\Service\Modify;
use App\Events\Admin\Service\Reject;
use App\Exports\OrdersExport;
use App\Exports\ServicesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\PostHarvestServicesDepartment;
use App\Models\Service;
use App\Models\ServiceClass;
use App\Models\ServiceQuantity;
use App\Models\ServiceTemp;
use App\Models\ServiceWarehouseStock;
use App\Models\Vendor;
use App\Models\Warehouse;
use App\Repositories\Admin\ServiceRepository as ServiceRepository;
use App\Services\Images\ServiceImageService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\ServiceImage;
use App\Models\ServiceNote;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    private $serviceRepository;
    private $serviceImageService;

    public function __construct(ServiceRepository $serviceRepository, ServiceImageService $serviceImageService) {
        $this->serviceRepository = $serviceRepository;
        $this->serviceImageService = $serviceImageService;
    }

    public function index(Request $request)
    {
        if($request->action == "exportExcel"){
            return Excel::download(new ServicesExport($request), 'services.xlsx');
        }

        return view(
            "admin.services.index",
            [
                'services' => $this->serviceRepository->getServicesPaginated(request()),
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
            $breadcrumbParent = 'admin.services.index';
            $breadcrumbParentUrl = route('admin.services.index');
            $vendors = Vendor::select('name', 'id','is_international')->whereJsonContains('services', 'agricultural_services')->get();
            $main_categories = $this->getMainCategoriesForSelect();
            $cities = City::select('id','name')->active()->get();

            return view("admin.services.create", compact('vendors', "breadcrumbParent", "breadcrumbParentUrl","main_categories","cities"));
        } catch (Exception $e) {
            Alert::error('', $e->getMessage());
            return redirect()->back();
            return redirect()->route('admin.home');
        }
    }


    public function store(CreateServiceRequest $request)
    {
        try {
            $data = $request->all();
            $service = $this->serviceRepository->store_service($data);
            if ($service) $this->serviceImageService->handleImages($service, true);
            return redirect(route('admin.services.index'))
                ->with(['success' => trans('admin.services.messages.created_successfully_title')]);
        } catch (Exception $e) {
            Alert::error('System Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($service_id)
    {
        try {
            $data['row'] = $this->serviceRepository->show(
                $service_id, [
                    'images', 'vendor.owner','category','temp'
                ]
            );

            if (isset($data['row'])) {
                $data['breadcrumbParent'] = 'admin.services.index';
                $data['breadcrumbParentUrl'] = route('admin.services.index');
                return view("admin.services.show", $data);
            }

        } catch (Exception $e) {
            return redirect()->route('admin.home');
        }
    }

    public function edit($id)
    {
        try {
            $data['row'] = $this->serviceRepository->show($id,['vendor:id,is_international']);
            $data['main_categories'] = $this->getMainCategoriesForSelect();
            $data['vendors'] =  Vendor::select('name', 'id','is_international')->whereJsonContains('services', 'agricultural_services')->get();
            $data['cities'] = City::select('id','name')->active()->get();

            if (isset($data['row'])) {
                $data['breadcrumbParent'] = 'admin.services.index';
                $data['breadcrumbParentUrl'] = route('admin.services.index');
                return view("admin.services.edit", $data);
            }
        } catch (Exception $e) {
            return redirect()->route('admin.home');
        }
    }

    public function update(UpdateServiceRequest $request, $id)
    {
       try {
            // $request->merge(['desc' => ['ar' => $request->desc_ar, 'en' => $request->desc_en]]);
            $data = $request->all();
            $service = $this->serviceRepository->update_service($data, $id);

            if ($service) {
                $this->serviceImageService->handleImages($service);
                // event(new Modify($service));
                return redirect()->route('admin.services.index')->with(['success' => trans('admin.services.messages.updated_successfully_title')]);
            }

        } catch (Exception $e) {
            Alert::error('System Error', $e->getMessage());
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        if (!$service_check = $this->serviceRepository->show($id))
            return redirect()->route('admin.services.index');

        if (Service::query()->find($id)->orderServices()->where('service_id', $id)->exists()){
            Alert::error('خطأ', 'يوجد عمليات بيع لهذا الخدمة فـ لا يمكن حذفه');
            return back();
        }


        try {
            $service = $this->serviceRepository->destroy_service($id);
            return redirect()->route('admin.services.index')->with(['success' => trans('admin.services.messages.deleted_successfully_title')]);
        } catch (Exception $e) {
            return redirect()->route('admin.home');
        }
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

    public function acceptService(Service $service) {

        if ($service->status != 'accepted'){
            $service->update(['status' => 'accepted', 'is_active' => 1, 'is_visible' => 1]);
            ServiceNote::where('service_id',$service->id)->delete();

            if($service->square_image_temp){
                $service->clearMediaCollection(Service::mediaCollectionName);
                Media::where(['model_id' => $service->id , 'model_type'=>'App\Models\Service', 'collection_name' => Service::mediaTempCollectionName])->update(['collection_name' => Service::mediaCollectionName]);
                $service->clearMediaCollection(Service::mediaTempCollectionName);
            }
            if($service->clearance_cert_media_temp){
                $service->clearMediaCollection(Service::clearanceCertCollectionName);
                Media::where(['model_id' => $service->id , 'model_type'=>'App\Models\Service', 'collection_name' => Service::clearanceCertTempCollectionName])->update(['collection_name' => Service::clearanceCertCollectionName]);
                $service->clearMediaCollection(Service::clearanceCertTempCollectionName);
            }
            ServiceImage::where('service_id',$service->id)->where('is_accept',0)->update([
                'is_accept'=>1
            ]);

            event(new Approve($service));
        }else if ($service->status != 'pending'){
            $service->update(['status' => 'pending', 'is_active' => 0]);
            event(new Reject($service));
        }
        return back()->with('success', __('admin.services.messages.status_changed_successfully_title'));
    }

    public function acceptUpdate(Service $service)
    {
        if($service->temp){
            $this->serviceRepository->updateServiceAfterAccept($service);
            if($service->square_image_temp){
                $service->clearMediaCollection(Service::mediaCollectionName);
                Media::where(['model_id' => $service->id , 'model_type'=>'App\Models\Service', 'collection_name' => Service::mediaTempCollectionName])->update(['collection_name' => Service::mediaCollectionName]);
                $service->clearMediaCollection(Service::mediaTempCollectionName);
            }
            if($service->clearance_cert_media_temp){
                $service->clearMediaCollection(Service::clearanceCertCollectionName);
                Media::where(['model_id' => $service->id , 'model_type'=>'App\Models\Service', 'collection_name' => Service::clearanceCertTempCollectionName])->update(['collection_name' => Service::clearanceCertCollectionName]);
                $service->clearMediaCollection(Service::clearanceCertTempCollectionName);
            }

            $service->temp()->delete();
        }
        ServiceImage::where('service_id',$service->id)->where('is_accept',0)->update([
            'is_accept'=>1
        ]);
        return back()->with('success', __('admin.services.messages.status_changed_successfully_title'));
    }

    public function approve(Service $service): \Illuminate\Http\JsonResponse
    {
        $service->status = 'accepted';
        $service->save();
        if($service->square_image_temp){
            $service->clearMediaCollection(Service::mediaCollectionName);
            Media::where(['model_id' => $service->id , 'model_type'=>'App\Models\Service', 'collection_name' => Service::mediaTempCollectionName])->update(['collection_name' => Service::mediaCollectionName]);
            $service->clearMediaCollection(Service::mediaTempCollectionName);
        }
        if($service->clearance_cert_media_temp){
            $service->clearMediaCollection(Service::clearanceCertCollectionName);
            Media::where(['model_id' => $service->id , 'model_type'=>'App\Models\Service', 'collection_name' => Service::clearanceCertTempCollectionName])->update(['collection_name' => Service::clearanceCertCollectionName]);
            $service->clearMediaCollection(Service::clearanceCertTempCollectionName);
        }
        ServiceImage::where('service_id',$service->id)->where('is_accept',0)->update([
            'is_accept'=>1
        ]);
        event(new Approve($service));
        return response()->json(['status' => 'success','data' => $service->status,'message' => __('admin.services.messages.status_approved_successfully_title')],200);
    }

    public function refuseUpdate(Service $service,Request $request)
    {
        if($service->temp){
            $service->temp()->update(['approval'=>ServiceTemp::REFUSED,'note'=>$request->note]);
        }
        return back()->with('success', __('admin.services.messages.status_changed_successfully_title'));
    }

    public function refuseDelete(Service $service)
    {
        if($service->temp){
            $service->temp()->update(['approval'=>ServiceTemp::PENDING,'note'=>NULL]);
        }
        return back()->with('success', __('admin.services.messages.status_changed_successfully_title'));
    }

    public function reject(Service $service,Request $request)
    {
        ServiceNote::updateOrCreate([
            'service_id'=>$service->id,
            ],[
            'note'=>$request->note
        ]);
        return back()->with('success', __('admin.services.messages.status_changed_successfully_title'));
    }

    public function printBarcode(Service $service) {
        return view("admin.services.print-barcode", ['service' => $service]);
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




    #خدمات شارفت على الإنتهاء
    public function almostOutOfStock(Request $request){
        if($request->action == "exportExcel"){
            $request['function'] = 'almostOutOfStock';
            return Excel::download(new ServicesExport($request), 'services-almostOutOfStock.xlsx');
        }

        $services = Service::where('stock','<=',10)->where('stock','>',0)
        ->search($request->search)
        ->when($request->vendor_id,fn($q) => $q->where('vendor_id', $request->vendor_id))
        ->latest()->paginate(50);

        $vendors = Vendor::available()->get();

        return view("admin.services.index", compact('services','vendors'));
    }

    #خدمات نفذت من المخزون
    public function outOfStock(Request $request){
        if($request->action == "exportExcel"){
            $request['function'] = 'outOfStock';
            return Excel::download(new ServicesExport($request), 'services-outOfStock.xlsx');
        }

        $services = Service::where('stock','<=',0)
        ->search($request->search)
        ->when($request->vendor_id,fn($q) => $q->where('vendor_id', $request->vendor_id))
        ->latest()->paginate(50);
        $vendors = Vendor::available()->get();

        return view("admin.services.index", compact('services','vendors'));
    }

    #خدمات محذوفة
    public function deleted(Request $request){
        if($request->action == "exportExcel"){
            $request['function'] = 'deleted';
            return Excel::download(new ServicesExport($request), 'services-deleted.xlsx');
        }

        $services = Service::onlyTrashed()
        ->search($request->search)
        ->when($request->vendor_id,fn($q) => $q->where('vendor_id', $request->vendor_id))
        ->latest()->paginate(50);
        $vendors = Vendor::available()->get();


        return view("admin.services.index", compact('services','vendors'));
    }

    public function refuseUpdate2(Service $service,Request $request)
    {
        if($service->note){
            $service->note()->update(['note'=>$request->note]);
        }
        return back()->with('success', __('admin.services.messages.status_changed_successfully_title'));
    }

    public function refuseDelete2(Service $service)
    {
        if($service->note){
            $service->note()->update(['note'=>NULL]);
        }
        return back()->with('success', __('admin.services.messages.status_changed_successfully_title'));
    }


}
