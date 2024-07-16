<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserTableSeeder::class);
        $this->call(VendorTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(ProductQuantityTableSeeder::class);
        $this->call(ProductClassSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(QnaTableSeeder::class);
        $this->call(ReviewTableSeeder::class);
        $this->call(GeographicSeeder::class);
        $this->call(WarehouseSeeder::class);
        $this->call(AddressSeeder::class);
       $this->call(TransactionSeeder::class);
       $this->call(OrderSeeder::class);
       $this->call(OrderProductSeeder::class);
       $this->call(OrderLogSeeder::class);
       $this->call(TransactionLogSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ExtraLangSettingSeeder::class);
        $this->call(UserVendorRateTableSeeder::class);
       $this->call(WalletTableSeeder::class);
        $this->call(RecipeSeeder::class);
        $this->call(BlogPostSeeder::class);
        $this->call(StaticContentSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(SubAdminRuleSeeder::class);
       $this->call(ProductWarehouseStockSeeder::class);
        $this->call(ShippingTypeTableSeeder::class);
        $this->call(WarehouseShippingTypeTableSeeder::class);
        $this->call(WarehouseCityTaleSeeder::class);
        $this->call(ShippingMethodTableSeeder::class);
        $this->call(ClientMessageSeeder::class);

    }
}
