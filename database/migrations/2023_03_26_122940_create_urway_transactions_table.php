<?php

use App\Services\Payments\Urway\Constants as UrwayConstants;
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
        Schema::create('urway_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("transaction_id");
            $table->enum("status", UrwayConstants::getStatuses())->default(UrwayConstants::pending);
            $table->string('urway_payment_id')->unique("urway_payment_id_index");
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
        Schema::dropIfExists('urway_transactions');
    }
};
