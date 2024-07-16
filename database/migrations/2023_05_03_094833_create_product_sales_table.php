<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('product_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index("product_id_index");
            $table->unsignedBigInteger('category_id')->index("category_id_index");
            $table->unsignedBigInteger('all_product_sales')->nullable()->comment("all quantity summation");
            $table->unsignedBigInteger('daily_product_sales')->nullable()->comment("yesterday quantity summation");
            $table->date('daily_sales_day')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sales');
    }
};
