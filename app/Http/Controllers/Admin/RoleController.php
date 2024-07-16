<?php

namespace App\Http\Controllers\Admin;

use App\Enums\VendorPermission;
use App\Exports\ClientExport;
use App\Exports\VendorsRolesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Vendor;
use App\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::orderBy('id', 'desc')
            ->when(request()->has('vendor_id') && !empty(request('vendor_id')), function ($q) {
            $q->where('vendor_id', request('vendor_id'));
        })->paginate(10);
        $vendors = Vendor::available()->get();

        return view('admin.roles.index',['roles' => $roles, 'vendors' => $vendors]);
    }
    public function exportVendorsWithRoles()
    {
        return Excel::download(new VendorsRolesExport(), 'roles.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = VendorPermission::getPermissionList();
        $vendors = Vendor::select('id','name->ar AS vendorName')->get();
        return view('admin.roles.add',[
            'permissions' => $permissions,
            'vendors' => $vendors,
            'breadcrumbParent' => 'admin.roles.index',
            'breadcrumbParentUrl' => route('admin.roles.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $role_attributes)
    {
        $data =$role_attributes->all();
        $data['permissions']=json_encode($role_attributes->permissions);
        Role::create($data);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = VendorPermission::getPermissionList();
        $vendors = Vendor::select('id','name->ar AS vendorName')->get();
        return view('admin.roles.edit',[
            'role' => $role,
            'permissions' => $permissions,
            'vendors' => $vendors,
            'breadcrumbParent' => 'admin.roles.index',
            'breadcrumbParentUrl' => route('admin.roles.index')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $role_attributes,Role $role)
    {
        $data =$role_attributes->all();
        $data['permissions']=json_encode($role_attributes->permissions);
        $role->update($data);
        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index');
    }
}
