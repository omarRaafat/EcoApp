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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image')->default('images/noimage.png');
            $table->json('name');
            $table->json('desc');
            $table->boolean('is_active')->default(0);
            $table->boolean('is_visible')->default(0);
            $table->enum('status',['pending','in_review','holded','accepted'])->default('pending');
            $table->double('total_weight')->nullable();
            $table->double('net_weight')->nullable();
            $table->string('barcode')->nullable();
            $table->double('length')->nullable();
            $table->double('width')->nullable();
            $table->double('height')->nullable();
            $table->double('price')->nullable();
            $table->double('price_before_offer')->nullable();
            $table->integer('order')->nullable();
            $table->timestamp('expire_date')->nullable();
            $table->integer('quantity_bill_count')->nullable();
            $table->double('bill_weight')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('quantity_type_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('quantity_type_id')->references('id')->on('quantity_types')->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('set null');
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
        Schema::dropIfExists('products');
    }
};
