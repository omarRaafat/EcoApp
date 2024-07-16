<?php

namespace App\Models;

class ProductWarehouse extends BaseModel
{
    protected $table = 'product_warehouse';
    protected $fillable=['product_id','quantity','quantity_bill_count','net_weight','quantity_type_id','warehouse_id'];

}
