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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->dateTime("date");
            $table->string('status');// registered,shipping_done,in_delivery,completed,canceled,refund
            $table->double("total")->nullable();
            $table->double("sub_total")->nullable();
            $table->double("total_vat")->nullable();
            $table->double("total_tax")->nullable();
            $table->string('code')->nullable();
            $table->integer("products_count");
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
        Schema::dropIfExists('transactions');
    }
};
