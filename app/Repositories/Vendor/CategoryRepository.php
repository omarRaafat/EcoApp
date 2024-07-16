<?php 
namespace App\Repositories\Vendor;
use App\Models\Category;
use App\Models\CategoryTranslation;

class CategoryRepository{

	public function getCategoryForSelect($level=1,$parent_id=null)
	{
		return Category::where('parent_id',$parent_id)->select('name','id')->pluck('name','id');
	}

}


?>