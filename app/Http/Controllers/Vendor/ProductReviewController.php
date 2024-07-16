<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\UserVendorRate;
use Illuminate\Http\Request;
use App\DataTables\ProductReviewDataTable;
use App\Repositories\Vendor\ProductRepository;

class ProductReviewController extends Controller
{
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository=$productRepository;
    }
    public function index(Request $request,ProductReviewDataTable $productReviewDataTable)
    {
        $review = UserVendorRate::first();
        // dd('wwww');
        $products=$this->productRepository->getAll();
        return $productReviewDataTable->render('vendor.products.product_reviews.index',compact('request','products'));
    }
}
