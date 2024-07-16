<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\UserStoreRequest;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use App\Models\TypeOfEmployee;
use App\Repositories\Vendor\UserRepository;
use App\Models\User;
use App\Repositories\Vendor\RoleRepository;

class VendorUserController extends Controller
{
    const COUNTRY_CODE = "+966";

    public function __construct(UserRepository $userRepository,public RoleRepository $roleRepository)
    {
        $this->userRepository=$userRepository;
        $this->view='vendor/users';
    }
    public function index(Request $request,UserDataTable $userDataTable)
    {
        return $userDataTable->render('vendor.users.index',compact('request'));
        return view($this->view.'/index');
    }

    public function create()
    {
        $typeOfEmployees = TypeOfEmployee::where('vendor_id',auth()->user()->vendor_id)->get(['id','name','level','user_id','vendor_id']);
        $roles=$this->roleRepository->getRolesForSelect();
        return view($this->view.'/create',compact('roles','typeOfEmployees'));
    }

    public function store(UserStoreRequest $request)
    {
        $request->merge(['phone' => self::COUNTRY_CODE . $request->get('phone'),'type_of_employee_id' => $request->type_of_employee_id]);
        $this->userRepository->store($request);
        return redirect('/vendor/users')->with('success',__('translation.user_created_successfully'));
    }

    public function edit(int $id)
    {
        $row=$this->userRepository->getUserWithRoleUsingID($id);
        $roles=$this->roleRepository->getRolesForSelect();
        $typeOfEmployees = TypeOfEmployee::where('user_id',auth()->user()->id)->get(['id','name','level']);
        return view($this->view.'/edit',compact('row','roles','typeOfEmployees'));
    }

    public function update(UserStoreRequest $request,User $user)
    {
        $request->merge(['phone' => self::COUNTRY_CODE . $request->get('phone'),'type_of_employee_id' => $request->type_of_employee_id]);
        $this->userRepository->update($request,$user);
        return redirect('/vendor/users')->with('success',__('translation.user_updated_successfully'));
    }

    public function destroy(User $user)
    {
        $model = User::where("id", $user->id)->where('vendor_id', auth()->user()->vendor_id)->where('type', 'sub-vendor')->first();
        if (!isset($model)) return abort(404);
        $model->delete();
        return true;
    }
}
