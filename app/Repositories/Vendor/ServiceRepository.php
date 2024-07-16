<?php
namespace App\Repositories\Vendor;
use App\Models\Service;
use App\Models\ServiceTemp;
use App\Models\ServiceImage;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\Enums\ServiceStatus;
use App\Models\PostHarvestServicesDepartmentField;
use App\Models\ServiceField;
use App\Models\ServiceNote;
use Carbon\Carbon;

class ServiceRepository{

	public function __construct(public LogService $logger){}

	public function getAll()
	{
		return Service::where('vendor_id',auth()->user()->vendor_id)->get();
	}
	public function getAllWithPagination(Request $request,$pagination=10)
	{
		$query = Service::where('vendor_id',auth()->user()->vendor_id);
		if ( isset($request->search) ) {
			$query = $query->where('name->'.app()->getLocale(),'LIKE','%'.$request->search.'%');
		}
		return $query->paginate($pagination);
	}

	public function getServicesPaginated(int $perPage = 10, $sort = 'desc',$request = null,)
    {
        $sort = strtolower($sort);
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';
        $search = $request->has('search') ? $request->search : null;
        return Service::where('vendor_id',auth()->user()->vendor_id)->when(
                $search,
                fn($q) => $q->where(
                    fn($subQ) => $subQ->where('name->ar', 'like', "%$search%")
                        ->orWhere('name->en', 'like', "%$search%")
                )
            )
           	 ->when(
                $request->has('type') && $request->type == 'temp',
                fn($q) => $q->has('temp')
            )->when(
                $request->has('type') && $request->type == 'pending',
                fn($q) => $q->where('status',ServiceStatus::PENDING)
            )
			->when($request->filled('is_active') && $request->is_active != 'all',
			    fn($q)=>$q->where('is_active' , $request->get('is_active')))
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
            ->orderBy('id', $sort)
            ->paginate($perPage);
    }

	public function countAll()
	{
		return Service::where('vendor_id',auth()->user()->vendor_id)->count();
	}
	public function find($id, array $relations = [])
	{
		$service = Service::where('vendor_id',auth()->user()->vendor_id)->with($relations)->findOrFail($id);
		$service->ar=['name'=>$service->getTranslation('name','ar'),'desc'=>$service->getTranslation('desc','ar'),'conditions'=>$service->getTranslation('conditions','ar')];
		$service->en=['name'=>$service->getTranslation('name','en'),'desc'=>$service->getTranslation('desc','en'),'conditions'=>$service->getTranslation('conditions','en')];
        $service->new_images=[];
        if($service->temp)
        {
            $service->new_images=array_diff($service->temp->images_array(),$service->images()->pluck('id')->toArray());
        }
		return $service;
	}

	public function store($data)
	{
		$data['vendor_id']=auth()->user()->vendor_id;
		unset($data['image']);
		$row=Service::create($data);

        if (isset($data['cities']) && is_array($data['cities'])) {
            $cities = $data['cities'];
            $row->cities()->attach($cities);
        }

        if (isset($data['fields'])) {
            foreach ($data['fields'] as $fieldName => $fieldData) {
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

		if (isset($data['images_array']) && isset($data['images_array'][0])) {
			$images = explode(',', $data['images_array'][0]);
			foreach($images as $image_id )
				ServiceImage::where('id',$image_id)->update(['service_id'=>$row->id]);
		}
		return $row;
	}

	public function update($data,$id)
	{
		$row = Service::where('vendor_id',auth()->user()->vendor_id)->with(['category'])->findOrFail($id);
        if ($row->status == 'accepted') {
            unset($data['fields']);
			$row->update([
				'is_visible'=>$data['is_visible' ],
				//'image' => $temp['image']
			]);
            $temp_data = $data;
            unset($temp_data['cities']);
			$temp=$this->createServiceTemp($row,$temp_data);
            $this->saveUpdatedData($temp,$row);

        }else{
			unset($data['image']);
			ServiceNote::where('service_id',$id)->delete();
            $row->update($data);
        }

        if (isset($data['cities']) && is_array($data['cities'])) {
            $cities = $data['cities'];
            $row->cities()->sync($cities);
        }

        // Store service fields
        if (isset($data['fields'])) {
            // Delete existing service fields for the current service
            ServiceField::where('service_id', $row->id)->delete();

            foreach ($data['fields'] as $fieldName => $fieldData) {
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

		if (isset($data['images_array']) && isset($data['images_array'][0])) {
            $images = explode(',', $data['images_array'][0]);
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

	public function delete($id)
	{
		Service::where('vendor_id',auth()->user()->vendor_id)->where('id',$id)->delete();
		return true;
	}

	private function createServiceTemp($service,$data)
	{
		$serviceData=[
			'status'=>'pending',
			'vendor_id'=>$service->vendor_id,
			'service_id'=>$service->id,
			'name'=>$data['name'],
			'desc'=>$data['desc'],
            'conditions'=>$data['conditions'],
			'category_id'=>$data['category_id'],
		];

		if (isset($data['image'])) {
		//	$serviceData['image']=$data['image'];
		}

		$serviceTemp=array_merge(['data'=>json_encode($data)],$serviceData);
		if ($service->serviceTemp != null) {
			$service->temp()->update(['approval'=>ServiceTemp::PENDING]);
			$service->serviceTemp->update($serviceTemp);
			$temp=$service->serviceTemp;
		}else{
			$temp=ServiceTemp::create($serviceTemp);
		}
		$this->logger->InLog([
            'user_id' => auth()->user()->id,
            'action' => "updateService",
            'model_type' => "\App\Models\Service",
            'model_id' => $service->id,
            'object_before' => $service,
            'object_after' => $temp
        ]);
        return $temp;
	}
	private function saveUpdatedData($temp,$service)
	{
		$tempData = array_diff_key(json_decode($temp->data,true), array_flip(["name", "desc", "conditions", "images_array","deleted_images_array","formAction","_method","_token"]));

		if(request()->hasFile('clearance_cert')){
			$tempData['clearance_cert']= $service->clearance_cert_media;
		}
		if(request()->hasFile('image')){
			$tempData['image'] = $service->square_image;
		}

		$serviceOldData=$service;
		$serviceOldData = $serviceOldData->setHidden(['vendor','created_at','updated_at','service_temp','name','desc','conditions'])->toArray();
		$serviceCollection=collect($tempData);

		$diff = $serviceCollection->diffAssoc($serviceOldData)->all();

		foreach(config()->get('app.locales') as $local)
		{
			if ($service->getTranslation('name',$local) != $temp->getTranslation('name',$local)) {
				$diff['name_'.$local]=$temp->getTranslation('name',$local);
			}
			if ($service->getTranslation('desc',$local) != $temp->getTranslation('desc',$local)) {
				$diff['desc_'.$local]=$temp->getTranslation('desc',$local);
			}
            if ($service->getTranslation('conditions',$local) != $temp->getTranslation('conditions',$local)) {
				$diff['conditions_'.$local]=$temp->getTranslation('conditions',$local);
			}
		}

		if(count($diff) == 4 && $diff['image_from'] == $service->square_image)
			{
				$temp->delete();
			}
			else{
				$temp->updated_data=json_encode($diff);
				$temp->save();
			}

	}

}
?>
