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
        // Fetch all vendors
        $vendors = DB::table('vendors')->get();

        foreach ($vendors as $vendor) {
            // Decode existing services or initialize an empty array
            $services = json_decode($vendor->services, true) ?? [];

            // Add selling_products if it's not already present
            if (!in_array('selling_products', $services)) {
                $services[] = 'selling_products';
            }

            // Update the vendor's services
            DB::table('vendors')
                ->where('id', $vendor->id)
                ->update(['services' => json_encode($services)]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Fetch all vendors
        $vendors = DB::table('vendors')->get();

        foreach ($vendors as $vendor) {
            // Decode existing services
            $services = json_decode($vendor->services, true) ?? [];

            // Remove selling_products if it's present
            if (($key = array_search('selling_products', $services)) !== false) {
                unset($services[$key]);
            }

            // Update the vendor's services
            DB::table('vendors')
                ->where('id', $vendor->id)
                ->update(['services' => json_encode(array_values($services))]);
        }
    }
};
