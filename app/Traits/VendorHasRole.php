<?php
namespace App\Traits;

use App\Enums\UserTypes;
use App\Models\Role;

trait VendorHasRole {
    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isVendorPermittedTo(string $permissionName) {
        if ($this->type == UserTypes::VENDOR) return true;
        elseif ($this->type == UserTypes::SUBVENDOR) {
            $permissionsSubVendor = auth()->user()->roles
                ->where('vendor_id', auth()->user()->vendor->id)
                ->pluck('permissions')
                ->flatten()
                ->toArray();
            return in_array($permissionName, $permissionsSubVendor);
        }
        return false;
    }
}
