<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendor;
use App\Http\Requests\Admin\VendorUserRequest;
use Illuminate\Pipeline\Pipeline;

class VendorUserController extends Controller
{
    const COUNTRY_CODE = "+966";

    public function index()
    {
        $query = User::with(['vendor'])->whereIn('type', ['sub-vendor', 'vendor']);
        $query = app(Pipeline::class)
            ->send($query)
            ->through([
                \App\Pipelines\Admin\VendorUser\FilterName::class,
                \App\Pipelines\Admin\VendorUser\FilterEmail::class,
                \App\Pipelines\Admin\VendorUser\FilterPhone::class,
                \App\Pipelines\Admin\VendorUser\FilterVendor::class,
            ])
            ->thenReturn();
        $users = $query->orderBy('vendor_id', 'asc')->paginate(10)->withQueryString();

        $vendors = Vendor::select('id', 'name->ar AS vendorName')->get();
        return view('admin.vendorUsers.index', ['users' => $users, 'vendors' => $vendors]);
    }

    public function add()
    {
        $vendors = Vendor::select('id', 'name->ar AS vendorName')->get();
        return view('admin.vendorUsers.add', [
            'vendors' => $vendors,
            'breadcrumbParent' => 'admin.vendor-users.index',
            'breadcrumbParentUrl' => route('admin.vendor-users.index')
        ]);
    }

    public function store(VendorUserRequest $user_attributes)
    {
        $user_attributes->merge(['phone' => self::COUNTRY_CODE . $user_attributes->get('phone')]);
        $user_attributes = $user_attributes->all();
        $user_attributes['type'] = 'sub-vendor';
        $vendorUser = User::create($user_attributes);
        if (isset($user_attributes['role_id'])) {
            $vendorUser->roles()->sync([$user_attributes['role_id']]);
        }
        return redirect()->route('admin.vendor-users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::select('id', 'name->ar AS text')->where('vendor_id', $user->vendor_id)->get();
        $vendors = Vendor::select('id', 'name->ar AS vendorName')->get();
        return view('admin.vendorUsers.edit', [
            'user' => $user,
            'roles' => $roles,
            'vendors' => $vendors,
            'breadcrumbParent' => 'admin.vendor-users.index',
            'breadcrumbParentUrl' => route('admin.vendor-users.index')
        ]);
    }

    public function update(VendorUserRequest $user_attributes, User $user)
    {
        $user_attributes->merge(['phone' => self::COUNTRY_CODE . $user_attributes->get('phone')]);
        $user_attributes = $user_attributes->all();
        $user->update($user_attributes);
        if (isset($user_attributes['role_id'])) {
            $user->roles()->sync([$user_attributes['role_id']]);
        }
        return redirect()->route('admin.vendor-users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.vendor-users.index');
    }

    public function block(User $user): \Illuminate\Http\JsonResponse
    {
        if ($user->is_banned == 0) {
            $user->is_banned = 1;
            $message = __('admin.vendor_user_blocked');
        } else {
            $user->is_banned = 0;
            $message = __('admin.vendor_user_unblocked');
        }
        $user->save();
        return response()->json(['status' => 'success', 'data' => $user->is_banned, 'message' => $message], 200);
    }

    public function getVendorRoles($id)
    {
        $roles = Role::select('id', 'name->ar AS text')->where('vendor_id', $id)->get()->toArray();

        if ($roles) {
            return response()->json(['status' => 'success', 'data' => $roles], 200);
        } else {
            return response()->json(['status' => 'fail', 'data' => []], 200);
        }
    }
}
