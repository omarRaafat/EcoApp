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
        Schema::dropIfExists("sliders");
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->string('identifier')->nullable();
            $table->json('category')->nullable();
            $table->json('offer')->nullable();
            $table->string('url')->nullable();
            $table->string('image');
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
        Schema::dropIfExists("sliders");
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('identifier')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
