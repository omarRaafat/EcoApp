<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
            \App\Models\Permission::where('route','["admin.reports.vendors_sales"]')->delete();
            DB::table('permissions')->insert(
                array(
                    'scope' => 'sub-admin',
                    'name' => '{"ar": " تقرير مبيعات المتاجر", "en": "Vendor Reports Sales"}',
                    'module' => '{"ar": "التقارير", "en": "Reports"}',
                    'route' => '["admin.reports.vendors_sales","admin.reports.vendors_sales_print"]',
                    'deleted_at' => NULL,
                    'created_at' => '2023-11-02 17:31:20',
                    'updated_at' => '2023-11-02 17:31:20',
                    'group' => 'reports',
                )
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
        });
    }
};
