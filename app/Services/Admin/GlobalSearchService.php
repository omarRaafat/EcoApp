<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Client;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Models\VendorWallet;
use App\Models\Warehouse;

class GlobalSearchService
{
    public function filterByClient($value)
    {
        $globalSearchResults = [];
        $clients = Client::query()
            ->where(function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%')
                    ->orWhere('phone', 'like', '%' . $value . '%')
                    ->orWhere('identity', 'like', '%' . $value  . '%');
            })
            ->take(7)
            ->get();

        if (count($clients) > 0) {
            foreach ($clients as $client) {
                $globalSearchResults[] = '<a  href="' . route('admin.customers.show', ['user' => $client->id]) . '">
                                <h6>اسم العميل : ' . htmlspecialchars($client->name) . '</h6>
                                <span class="text-secondary" style="font-size: 13px">رقم الجوال : ' . htmlspecialchars($client->phone) . '</span>
                                </a>';
            }
        }

        return $globalSearchResults;
    }
    public function filterByVendors($value)
    {
        $globalSearchResults = [];

        $vendors = Vendor::query()
            ->where(function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%')
                    ->orWhere('name_in_bank', 'like', '%' . $value . '%')
                    ->orWhere('commercial_registration_no', 'like', '%' . $value . '%')
                    ->orWhere('ipan', 'like', '%' . $value . '%')
                    ->orWhere('bank_num', 'like', '%' . $value . '%')
                    ->orWhere('desc', 'like', '%' . $value . '%');
            })
            ->take(4)
            ->get();

        if (count($vendors) > 0) {
            foreach ($vendors as $vendor) {
                $globalSearchResults[] = '<a href="' . route('admin.vendors.show', ['vendor' => $vendor->id]) . '">
                                    <h6>اسم المتجر : ' . htmlspecialchars($vendor->name) . '</h6>
                                     </a>';
            }
        }
        return $globalSearchResults;
    }
    public function filterByOrders($value)
    {
        $globalSearchResults = [];

        $transactions = Transaction::query()
            ->with(["customer"])
            ->where(function ($query) use ($value) {
                $query->where('code', 'like', '%' . $value . '%')
                    ->orWhere('customer_name', 'like', '%' . $value . '%')
                    ->orWhereHas('customer', function ($query) use ($value) {
                        $query->where('phone', 'like', '%' . $value . '%');
                    });
            })
            ->take(8)->get();

        if (count($transactions) > 0) {
            foreach ($transactions as $transaction) {
                $globalSearchResults[] = '<a  href="' . route('admin.transactions.show', ['transaction' => $transaction->id]) . '">
                                    <h6>كود الطلب: ' . htmlspecialchars($transaction->code) . '</h6>
                                    <span class="text-secondary" style="font-size: 13px">اسم العميل ' . htmlspecialchars($transaction->customer_name) . '</span>
                                    </a>';
            }
        }
        return $globalSearchResults;
    }
    public function filterByVendorsUsers($value)
    {
        $globalSearchResults = [];

        $users = User::query()
            ->with(['vendor'])->whereIn('type', ['sub-vendor', 'vendor'])
            ->where(function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%')
                    ->orWhere('phone', 'like', '%' . $value . '%')
                    ->orWhere('email', 'like', '%' . $value . '%');
            })
            ->take(4)
            ->get();

        if (count($users) > 0) {
            foreach ($users as $user) {
                $globalSearchResults[] = '<a href="' . route('admin.vendor-users.edit', ['user' => $user])  . '">
                                    <h6>اسم المستخدم : ' . htmlspecialchars($user->name) . '</h6>
                                    <div class="row">
            <span class="text-secondary" style="font-size: 12px">اسم المتجر: ' . htmlspecialchars($user->vendor?->name) . '</span>
                                    </div>
                                     </a>';
            }
        }
        return $globalSearchResults;
    }
    public function filterByProducts($value)
    {
        $globalSearchResults = [];

        $products = Product::query()->where(function ($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%')
                ->orWhere('desc', 'like', '%' . $value . '%')
                ->orWhereHas('category', function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%');
                });
        })->take(8)
            ->get();

        if (count($products) > 0) {
            foreach ($products as $product) {
                $globalSearchResults[] = '<a href="' . route('admin.products.show', $product->id)  . '">
                                <h6>اسم المنتج : ' . htmlspecialchars($product->name) . '</h6>
                                <div class="row">
        <span class="text-secondary" style="font-size: 12px"> المتجر: ' . htmlspecialchars($product->vendor?->name) . '</span>
                                </div>
                                 </a>';
            }
        }
        return $globalSearchResults;
    }
    public function filterByWarehouse($value)
    {
        $globalSearchResults = [];

        $warehouses = Warehouse::query()->where(function ($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%')
                ->orWhere('administrator_name', 'like', '%' . $value . '%')
                ->orWhere('administrator_phone', 'like', '%' . $value . '%')
                ->orWhere('administrator_email', 'like', '%' . $value . '%')
                ->orWhere('latitude', 'like', '%' . $value . '%')
                ->orWhere('longitude', 'like', '%' . $value . '%');
        })->take(8)
            ->get();

        if (count($warehouses) > 0) {
            foreach ($warehouses as $warehouse) {
                $globalSearchResults[] = '<a href="' . route("admin.warehouses.show", $warehouse->id)  . '">
                                <h6>اسم المستودع : ' . htmlspecialchars($warehouse->name) . '</h6>
                                <div class="row">
        <span class="text-secondary" style="font-size: 12px">اسم المسؤول :' . htmlspecialchars($warehouse->administrator_name) . '</span>
                                </div>
                                 </a>';
            }
        }
        return $globalSearchResults;
    }
    public function filterByVendorsWallet($value)
    {
        $globalSearchResults = [];


        $vendorWallets = VendorWallet::query()
            ->with(["vendor", "vendor.owner"])
            ->where(function ($query) use ($value) {
                $query->whereHas('vendor', function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%');
                });
            })
            ->take(5)->get();

        if (count($vendorWallets) > 0) {
            foreach ($vendorWallets as $wallet) {
                $globalSearchResults[] = '<a href="' . route("admin.vendorWallets.show", $wallet->id)  . '">
                                <h6>اسم المتجر: ' . htmlspecialchars($wallet->vendor?->name) . '</h6>
                                <div class="row">
        <span class="text-secondary" style="font-size: 12px">اسم المالك :' . htmlspecialchars($wallet->vendor?->owner?->name) . '</span>
                                </div>
                                 </a>';
            }
        }
        return $globalSearchResults;
    }
}
