<?php


namespace App\Repositories\Admin;

use App\Enums\SettingEnum;
use App\Models\Category;
use App\Models\Country;
use App\Models\PostHarvestServicesDepartmentField;
use App\Models\Service;
use App\Models\ServiceField;
use Illuminate\Support\Str;
use App\Models\ServiceImage;
use App\Models\ServicePrice;
use App\Models\Setting;
use App\Repositories\Api\BaseRepository;
use Carbon\Carbon;

class ServiceRepository extends BaseRepository
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

    public function getServicesPaginated($request = null, int $perPage = 10, $sort = 'desc')
    {
        $sort = strtolower($sort);
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';
        $search = $request->has('search') ? $request->search : null;
        return $this->model->with('category','vendor','note','temp','media')
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
                $qn->whereHas('serviceTemp' , function($sqn){
                    $sqn->where('note', '!=', null);
                })
            )
            ->when( $request->get('status') != 'pending' && $request->filled('note') && $request->get('note') == 0  , fn($qn) =>
            $qn->whereHas('serviceTemp' , function($sqn){
                $sqn->whereNote(NULL);
            })
        )
            ->orderBy('id', $sort)
            ->paginate($perPage);
    }

    public function show($service_id, array $relations = [])
    {
        $service = $this->model->with($relations)->findOrFail($service_id);
        $service->ar = ['name' => $service->getTranslation('name', 'ar'), 'desc' => $service->getTranslation('desc', 'ar'), 'conditions' => $service->getTranslation('conditions', 'ar')];
        $service->en = ['name' => $service->getTranslation('name', 'en'), 'desc' => $service->getTranslation('desc', 'en'), 'conditions' => $service->getTranslation('conditions', 'en')];
        $service->new_images=[];
        if($service->temp)
        {
            $service->new_images=array_diff($service->temp->images_array(),$service->images()->pluck('id')->toArray());
        }
        return $service;
    }

    public function store_service($data_request)
    {
        $data_request['status'] = 'accepted';
        // $data_request['is_visible'] = 1;
        unset($data_request['image']);
        $service = $this->model->create($data_request);

        if (isset($data_request['cities']) && is_array($data_request['cities'])) {
            $cities = $data_request['cities'];
            $service->cities()->attach($cities);
        }

        // Store service fields
        if (isset($data_request['fields'])) {
            foreach ($data_request['fields'] as $fieldName => $fieldData) {
                $field = PostHarvestServicesDepartmentField::where('name', $fieldName)->first();
                if ($field) {
                    if ($field->type === 'dropdown-list' && isset($fieldData['value']) && is_array($fieldData['value'])) {
                        foreach ($fieldData['value'] as $dropdownValue) {
                            if (isset($fieldData['price'][$dropdownValue]) && $fieldData['price'][$dropdownValue] !== null) {
                                $fieldPrice = $fieldData['price'][$dropdownValue];
                                ServiceField::create([
                                    'service_id' => $service->id,
                                    'field_name' => $fieldName,
                                    'field_value' => $dropdownValue,
                                    'field_type' => $field->type, // Assuming field_type is a column in the fields table
                                    'field_price' => $fieldPrice,
                                ]);
                            }
                        }
                    } else {
                        // Handle other field types, including checkboxes
                        $fieldValue = isset($fieldData['value']) ? (is_array($fieldData['value']) ? implode(',', $fieldData['value']) : $fieldData['value']) : null;
                        $fieldPrice = isset($fieldData['price']) && $fieldData['price'] !== null ? $fieldData['price'] : null;

                        ServiceField::create([
                            'service_id' => $service->id,
                            'field_name' => $fieldName,
                            'field_value' => $fieldValue,
                            'field_type' => $field->type, // Assuming field_type is a column in the fields table
                            'field_price' => $fieldPrice,
                        ]);
                    }
                }
            }
        }

        if (isset($data_request['images_array']) && isset($data_request['images_array'][0])) {
            $images = explode(',', $data_request['images_array'][0]);
            foreach ($images as $image_id)
                ServiceImage::where('id', $image_id)->update(['service_id' => $service->id]);
        }
        return $service;
    }

    public function update_service($data_request, $id)
    {
        $row = $this->model->findOrFail($id);
        unset($data_request['image']);
        $row->update($data_request);

        if (isset($data_request['cities']) && is_array($data_request['cities'])) {
            $cities = $data_request['cities'];
            $row->cities()->sync($cities);
        }

        // Delete existing service fields for the current service
        ServiceField::where('service_id', $row->id)->delete();

        // Store service fields
        if (isset($data_request['fields'])) {
            foreach ($data_request['fields'] as $fieldName => $fieldData) {
                $field = PostHarvestServicesDepartmentField::where('name', $fieldName)->first();
                if ($field) {
                    if ($field->type === 'dropdown-list' && isset($fieldData['value']) && is_array($fieldData['value'])) {
                        foreach ($fieldData['value'] as $dropdownValue) {
                            if (isset($fieldData['price'][$dropdownValue]) && $fieldData['price'][$dropdownValue] !== null) {
                                $fieldPrice = $fieldData['price'][$dropdownValue];
                                ServiceField::create([
                                    'service_id' => $row->id,
                                    'field_name' => $fieldName,
                                    'field_value' => $dropdownValue,
                                    'field_type' => $field->type, // Assuming field_type is a column in the fields table
                                    'field_price' => $fieldPrice,
                                ]);
                            }
                        }
                    } else {
                        // Handle other field types, including checkboxes
                        $fieldValue = isset($fieldData['value']) ? (is_array($fieldData['value']) ? implode(',', $fieldData['value']) : $fieldData['value']) : null;
                        $fieldPrice = isset($fieldData['price']) && $fieldData['price'] !== null ? $fieldData['price'] : null;

                        ServiceField::create([
                            'service_id' => $row->id,
                            'field_name' => $fieldName,
                            'field_value' => $fieldValue,
                            'field_type' => $field->type, // Assuming field_type is a column in the fields table
                            'field_price' => $fieldPrice,
                        ]);
                    }
                }
            }
        }

        if (isset($data_request['images_array']) && isset($data_request['images_array'][0])) {
            $images = explode(',', $data_request['images_array'][0]);
            ServiceImage::whereIn('id', $images)->update(['service_id' => $row->id]);

            if(request()->deleted_images_array){
                $arryIds = explode(',',trim(request()->deleted_images_array,','));
                $deletesServiceImage = ServiceImage::where('service_id',$row->id)->whereIn('id', $arryIds)->get();
                foreach ($deletesServiceImage as $key => $serviceImage) {
                    $serviceImage->clearMediaCollection(ServiceImage::mediaCollectionName);
                }

                $row->images()->whereIn('id', $arryIds)->delete();
            }
        }
        return $row;

    }

    public function destroy_service($id)
    {
        $service = $this->model->find($id);
        if ($service == NULL)
            return false;
        $service->delete();
    }

    public function getCategoryForSelect($level = 1, $parent_id = null)
    {
        $categories = Category::where('parent_id', $parent_id)->pluck('name', 'id')->toArray();
        return $categories;
    }

    function model(): string
    {
        return Service::class;
    }

    public function calculateRate(int $service_id)
    {
        $service = $this->model->findOrFail($service_id);

        $rate = $service->approvedReviews()->avg('rate');
        $count = $service->approvedReviews()->count();

        $service->rate = $rate ?? 0;
        $service->reviews_count = $count;
        $service->save();
    }

    public function updateServiceAfterAccept($service)
    {
        //Translated Data
        foreach (\Config::get('app.locales') as $locale) {
            if($service->getTranslation('name',$locale) != $service->temp->getTranslation('name',$locale)){
                $service->setTranslations('name', [$locale=>$service->temp->getTranslation('name',$locale)]);
            }
            if($service->getTranslation('desc',$locale) != $service->temp->getTranslation('desc',$locale)){
                $service->setTranslations('desc', [$locale=>$service->temp->getTranslation('desc',$locale)]);
            }
            if($service->getTranslation('conditions',$locale) != $service->temp->getTranslation('conditions',$locale)){
                $service->setTranslations('conditions', [$locale=>$service->temp->getTranslation('conditions',$locale)]);
            }
        }

        //Core Data
        $updated_data=json_decode($service->temp->updated_data,true);
        unset($updated_data['image']);
        $service->update($updated_data);

        //Images
        ServiceImage::where('service_id',$service->id)->update(['service_id'=>null]);
        ServiceImage::whereIn('id',$service->temp->images_array())->update(['service_id'=>$service->id]);
    }

}
