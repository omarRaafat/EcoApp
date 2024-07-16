<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\Api\CartService;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $carts = Cart::with(['products','user','cartProducts'])
            ->whereHas('cartProducts', function ($query) {
                $query->whereNotNull('product_id')->whereNull('service_id');
            })
            ->whereHas('user', function ($query) use ($request) {
                $query->filterBySearch(trim($request->search));
            })->latest()->paginate(50);

        return view('admin.cart.index',['carts' => $carts]);
    }

    public function show(Cart $cart)
    {
        return view('admin.cart.show',[
            'cart' => $cart,
            'breadcrumbParent' => 'admin.carts.index',
            'breadcrumbParentUrl' => route('admin.carts.index')
        ]);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect('admin/carts/');
    }
}
