<?php

namespace App\Http\Controllers\Admin;

use App\Models\BestSellingCategory;
use App\Models\BestSellingVendors;
use App\Models\MostDemandingCustomers;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Vendor;
use App\Models\Product;
use App\Enums\OrderStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\BestSellingProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Client;

class AdminController extends Controller
{
    public function index(Request $request)
    {

        $customers = Client::count();
        $vendorsCount = Vendor::count();
        $products = Product::count();
        $ordersCount = Order::notCancelled()->count();
        $totalOrdersCount = Order::count();
        $totalTransactionCount = Transaction::where('status' , 'completed')->count();
        $orders_status_count = Order::select( DB::raw('count(status) as status_count, status') )->groupBy('status')->get();
        $company_profit =  number_format(Order::delivered()->sum('company_profit'), 2, '.', '');
        $sales = Order::delivered()->sum('total');

        $bestProducts = BestSellingProduct::whereHas('product')->orderBy('product_sales','desc')->take(5)->get();
        $transactionsCity = Transaction::with('city')->where('status' , 'completed')->select('city_id', DB::raw('COUNT(*) as transaction_count'))->groupBy('city_id')->get();
        $vendors = BestSellingVendors::take(5)->orderBy('vendors_sales' , 'desc')->get();
        $categories = BestSellingCategory::take(5)->orderBy('category_sales' , 'desc')->get();
//        $customers = MostDemandingCustomers::select('customer_id', DB::raw('count(*) as total'))->groupBy('customer_id')->take(5)->orderBy('total' , 'desc')->get();
        return view('admin.index', compact('vendors','categories', 'company_profit', 'sales', 'bestProducts', 'transactionsCity', "vendorsCount", "products", "customers", "ordersCount", "orders_status_count","totalOrdersCount","totalTransactionCount"));
    }

    public function chartApi()
    {
        $orders = DB::table('Orders')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        if($orders->count() > 0) {
            $response = [];
            foreach($orders as $order) {
                $response["status"][] = OrderStatus::getStatus($order->status);
                $response["total"][] = $order->total;
            }
            return $response;
        }

        return [];
    }

    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }
}
