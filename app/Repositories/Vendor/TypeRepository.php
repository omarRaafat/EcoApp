<?php 
namespace App\Repositories\Vendor;
use App\Models\Type;
use App\Models\TypeTranslation;

class TypeRepository{

	public function getTypeForSelect()
	{
		$types=Type::pluck('name','id')->toArray();
		return $types;
	}

}


?>