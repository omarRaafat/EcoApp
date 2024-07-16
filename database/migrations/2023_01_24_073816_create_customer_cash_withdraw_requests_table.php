<?php

use App\Enums\CustomerWithdrawRequestEnum;
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
        Schema::create('customer_cash_withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->enum('admin_action', CustomerWithdrawRequestEnum::statuses())->default(CustomerWithdrawRequestEnum::PENDING);
            $table->string('bank_receipt')->nullable();
            $table->string('reject_reason')->nullable();
            $table->string('bank_name');
            $table->string('bank_account_name');
            $table->string('bank_account_iban')->index('iban_index');
            $table->double('amount', 10, 2);
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
        Schema::dropIfExists('customer_cash_withdraw_requests');
    }
};
