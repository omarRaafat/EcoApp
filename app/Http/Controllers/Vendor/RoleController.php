<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\RoleRequest;
use App\Enums\VendorPermission;
use App\Repositories\Vendor\RoleRepository;
use App\Models\Role;

class RoleController extends Controller
{
    private string $view;

    public function __construct(public RoleRepository $roleRepository)
    {
        $this->view = 'vendor.roles';
    }

    public function index()
    {
        return view($this->view .'.index', [
            'collection' => Role::descOrder()->vendorId(auth()->user()->vendor_id)->paginate(10)
        ]);
    }

    public function create()
    {
        $data['permissions'] = VendorPermission::getPermissionList();
        return view($this->view .'.create', $data);
    }

    public function store(RoleRequest $request)
    {
        $this->roleRepository->store($request);
        return redirect(route("vendor.roles.index"))->with('success', __('translation.role_created_successfully'));
    }

    public function edit(int $id)
    {
    
        $data['row'] = $this->roleRepository->find($id);
        $data['permissions'] = VendorPermission::getPermissionList();

        return view($this->view.'.edit', $data);
    }

    public function update(RoleRequest $request,Role $role)
    {
        $this->roleRepository->update($request, $role);
        return redirect(route("vendor.roles.index"))->with('success', __('translation.role_updated_successfully'));
    }

    public function destroy(Role $role)
    {
        $this->roleRepository->deleteById($role->id);
        return redirect(route("vendor.roles.index"))->with('success', __('vendors.role_deleted_successfully'));
    }
}
