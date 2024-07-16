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
        Schema::create('tabby_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("transaction_id");
            $table->enum("status", \App\Services\Payments\Urway\Constants::getStatuses())->default(\App\Services\Payments\Urway\Constants::pending);
            $table->string('tabby_payment_id')->unique("tabby_payment_id_index");
            $table->string('currency')->nullable();
            $table->string('customer_ip')->nullable();
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
        Schema::dropIfExists('tabby_transactions');
    }
};
