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
        Schema::create('torod_companies', function (Blueprint $table) {
            $table->id();
            $table->json("name");
            $table->json("desc");
            $table->boolean("active_status")->default(false);
            $table->unsignedBigInteger("delivery_fees");
            $table->unsignedBigInteger("domestic_zone_id");
            $table->unsignedBigInteger("torod_courier_id")->unique();
            $table->softDeletes();
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
        Schema::dropIfExists('torod_companies');
    }
};
