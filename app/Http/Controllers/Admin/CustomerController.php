<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClientExport;
use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Transaction;
use App\Services\Eportal\Connection;
use App\Services\LogService;
use App\Models\User;
use App\Traits\PaginationTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pipeline\Pipeline;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Html\Options\Languages\Paginate;
use App\Models\Client;

class CustomerController extends Controller
{
    //
    public $logger;

    use PaginationTrait;

    public function __construct(LogService $logger){
        $this->logger = $logger;
    }

    public function index(Request $request)
    {

        $customers = Client::query()
        ->filterBySearch(trim($request->search))
        ->latest()->paginate(50);

        return view('admin.customer.index',compact('customers'));
    }

    public function exportCustomers()
    {
        return Excel::download(new ClientExport(), 'customers.xlsx');
    }
    public function show($id)
    {
        $customer = Client::findOrFail($id);
        $transactions = Transaction::with('orders')->where('customer_id' , $customer->id)->paginate(50);
        return view('admin.customer.show',[
            'customer'              => $customer,
            'transactions'          => $transactions,
            'breadcrumbParent'      => 'admin.customers.index',
            'breadcrumbParentUrl'   => route('admin.customers.index')
        ]);
    }

    public function changePriority(User $user): \Illuminate\Http\JsonResponse
    {
        $old_user = User::find($user->id);
        $user->priority = request()->all()['priority'];
        $user->save();
        $this->logger->InLog([
            'user_id' => auth()->user()->id,
            'action' => "changePriority",
            'model_type' => "\App\Models\User",
            'model_id' => $user->id,
            'object_before' => $old_user,
            'object_after' => $user
        ]);
        return response()->json(['status' => 'success','data' => $user->priority],200);
    }

    public function block(User $user): \Illuminate\Http\JsonResponse
    {
        if($user->is_banned == 0)
        {
            $user->is_banned = 1;
            $message = __('admin.customer_blocked');
        }
        else
        {
            $user->is_banned = 0;
            $message = __('admin.customer_unblocked');
        }
        $user->save();
        return response()->json(['status' => 'success','data' => $user->is_banned,'message' => $message],200);
    }
}
