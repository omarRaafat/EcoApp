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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('warehouses');
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->json("name");
            $table->string("torod_warehouse_name")->nullable();
            $table->string("integration_key")->unique();
            $table->string("administrator_name");
            $table->string("administrator_phone");
            $table->string("administrator_email");
            $table->text("map_url")->nullable();
            $table->string("latitude")->nullable();
            $table->string("longitude")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('warehouses');
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->boolean('is_default')->default(0);
            $table->boolean('is_express')->default(0);
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }
};
