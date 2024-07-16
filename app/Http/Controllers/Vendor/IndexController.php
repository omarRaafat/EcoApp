<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\OrderStatus;
use App\Enums\UserTypes;
use App\Http\Controllers\Controller;
use App\Models\BestSellingProduct;
use App\Models\CountryOrder;
use App\Models\Order;
use App\Models\StatisitcsCount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $vendor = $user->vendor;
        $ordersCount = Order::query()
            ->where('vendor_id', $vendor->id)
            ->whereIn('status', ['completed', 'processing', 'in_shipping', 'registered'])
            ->count();
        $totalOrdersCount = Order::where('vendor_id', $vendor->id)->count();
        $totalTransactionCount = Transaction::whereHas('orders', function ($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })->where('status' , 'completed')->count();
        $total_sell = Order::where('vendor_id', $vendor->id)->where('status', 'completed')->sum('total');
        $total_earn = Order::where('vendor_id', $vendor->id)->where('status', 'completed')->sum('vendor_amount');
        $statisticsCounts = StatisitcsCount::where("vendor_id", $vendor->id)->first();
        $bestProducts = BestSellingProduct::where("vendor_id", $vendor->id)->whereHas('product')->orderBy('product_sales','desc')->take(5)->get();
        $ordersByCountries = CountryOrder::where("vendor_id", $vendor->id)->take(5)->get();
        $orders_status_count = Order::where('vendor_id', $vendor->id)->select( DB::raw('count(status) as status_count, status') )->groupBy('status')->get();
        $agreement = $user->type == UserTypes::VENDOR ? $vendor->agreements()->pending()->first() : null;
        $transactionsCity = Transaction::with('city')->whereHas('orders', function ($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })->where('status', 'completed')->select('city_id', DB::raw('COUNT(*) as transaction_count'))->groupBy('city_id')->get();
        return view('vendor.index', compact('total_earn', 'total_sell', 'statisticsCounts', 'bestProducts', 'ordersByCountries', 'agreement', 'transactionsCity', 'ordersCount', 'orders_status_count',"totalOrdersCount","totalTransactionCount"));
    }

    public function chartApi()
    {
        $orders = DB::table('orders')
            ->where("vendor_id", "=", auth()->user()->vendor->id)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        if ($orders->count() > 0) {
            $response = [];
            foreach ($orders as $order) {
                $response["status"][] = OrderStatus::getStatus($order->status);
                $response["total"][] = $order->total;
            }
            return $response;
        }

        return [];
    }
}
