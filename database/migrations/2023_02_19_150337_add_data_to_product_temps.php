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
        Schema::table('product_temps', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('quantity_type_id')->nullable();
            $table->unsignedBigInteger('product_class_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('final_category_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('sub_category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('final_category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('quantity_type_id')->references('id')->on('product_quantities')->onDelete('set null');
            $table->foreign('product_class_id')->references('id')->on('product_classes')->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('product_classes')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_temps', function (Blueprint $table) {
            $table->dropForeign('product_temps_category_id_foreign');
            $table->dropForeign('product_temps_sub_category_id_foreign');
            $table->dropForeign('product_temps_final_category_id_foreign');
            $table->dropForeign('product_temps_quantity_type_id_foreign');
            $table->dropForeign('product_temps_product_class_id_foreign');
            $table->dropForeign('product_temps_type_id_foreign');
            $table->dropColumn('category_id');
            $table->dropColumn('quantity_type_id');
            $table->dropColumn('product_class_id');
            $table->dropColumn('sub_category_id');
            $table->dropColumn('final_category_id');
            $table->dropColumn('type_id');
        });
    }
};
