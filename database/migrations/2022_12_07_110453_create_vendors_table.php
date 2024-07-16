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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('desc')->nullable();
            $table->boolean('is_active')->default(0);
            $table->enum('approval',['approved','not_approved','pending'])->default('pending');
            $table->text('street')->nullable();
            $table->string('logo')->default('images/nologo.png');
            $table->bigInteger('tax_num')->nullable();
            $table->string('cr')->default('images/noimage.png'); // Commecral Register
            $table->timestamp('crd')->nullable(); // Commecral Register Date
            $table->string('bank_name')->nullable();
            $table->string('broc')->default('images/noimage.png'); // Brand Rights Ownership Certificate
            $table->string('tax_certificate')->default('images/noimage.png');
            $table->bigInteger('bank_num')->nullable(); // Bank Account Number
            $table->string('ipan')->nullable(); // Ipan
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('users',function(Blueprint $table){
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->enum('type',['vendor','customer','admin'])->default('customer');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};
