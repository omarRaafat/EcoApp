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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code')->unique();
            $table->float('amount');
            $table->float('minimum_amount');
            $table->float('maximum_amount');
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->enum('status' , ['enable'  , 'disable'])->default('disable');
            $table->enum('coupon_type' , ['global','vendor','product','free_delivery'])->default('global');
            $table->integer('maximum_redemptions_per_user')->nullable();
            $table->integer('maximum_redemptions_per_coupon')->nullable();
            $table->enum('duration_Type' , ['one_time','forever','limited'])->default('forever');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expire_at')->nullable();
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
        Schema::dropIfExists('coupons');
    }
};
