<?php 
namespace App\Repositories\Vendor;
use App\Models\QuantityType;
use App\Models\QuantityTypeTranslation;

class QuantityTypeRepository{

	public function getQuantityTypeForSelect()
	{
		$quantity_types=QuantityType::pluck('name','id')->toArray();
		return $quantity_types;
	}

}


?>