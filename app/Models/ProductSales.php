<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSales extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id", "all_product_sales", "daily_product_sales", "daily_sales_day", "category_id"
    ];
}
