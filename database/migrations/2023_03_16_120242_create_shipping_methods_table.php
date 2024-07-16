<?php

use App\Enums\ShippingMethodType;
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
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->json("name");
            $table->string("logo")->nullable();
            $table->string("integration_key")->unique("integration_key_unique_index");
            $table->double('delivery_fees', 12, 2)->nullable();
            $table->unsignedInteger('delivery_fees_covered_kilos')->nullable();
            $table->double('additional_kilo_price', 9, 2)->nullable();
            $table->double('cod_collect_fees', 9, 2)->nullable();
            $table->enum("type", ShippingMethodType::getTypes());
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
        Schema::dropIfExists('shipping_methods');
    }
};
