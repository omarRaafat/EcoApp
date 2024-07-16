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
        Schema::create('api_requests', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("model_name")->nullable();
            $table->unsignedBigInteger("model_id")->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string("url")->nullable();
            $table->longText("req")->nullable();
            $table->longText("res")->nullable();
            $table->string("http_code")->nullable();
            $table->json('dataUpdated')->nullable();
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
        Schema::dropIfExists('api_requests');
    }
};
