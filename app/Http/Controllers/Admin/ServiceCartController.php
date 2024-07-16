<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\Api\CartService;
use Illuminate\Http\Request;


class ServiceCartController extends Controller
{
    public $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $carts = Cart::with(['services', 'user', 'cartProducts'])
        ->whereHas('cartProducts', function ($query) {
            $query->whereNotNull('service_id')->whereNull('product_id');
        })
        ->whereHas('user', function ($query) use ($request) {
            $query->filterBySearch(trim($request->search));
        })
        ->latest()
        ->paginate(50);

        return view('admin.service-cart.index',['carts' => $carts]);
    }

    public function show(Cart $cart)
    {
        return view('admin.service-cart.show',[
            'cart' => $cart,
            'breadcrumbParent' => 'admin.carts.index',
            'breadcrumbParentUrl' => route('admin.service_carts.index')
        ]);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect('admin/service-carts/');
    }
}
