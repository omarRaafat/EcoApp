<?php

use App\Enums\OrderStatus;
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
        Schema::create('order_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->string('user_id')->nullable();
            $table->dateTime('order_date');
            $table->string('customer_name')->nullable();
            $table->string('status')->default(OrderStatus::REGISTERD);
            $table->double('sub_total')->nullable();
            $table->double('total')->nullable();
            $table->double('tax')->nullable();
            $table->double('vat')->nullable();
            $table->string('code')->nullable();
            $table->integer('wallet_id')->nullable();
            $table->double('wallet_amount')->nullable();
            $table->double('visa_amount')->nullable();
            $table->tinyInteger('use_wallet')->nullable();
            $table->integer('payment_id')->nullable();
            $table->text('notes')->nullable();
            $table->double('vat_percentage')->nullable();
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
        Schema::dropIfExists('order_services');
    }
};
