<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string("number")
                ->unique();
            $table->uuid();
            $table->date("period");
            $table->foreignId("vendor_id")
                ->constrained("vendors");
            $table->json("vendor_data");
            $table->json("center_data");
            $table->unsignedBigInteger("total_without_vat");
            $table->unsignedBigInteger("vat_amount");
            $table->unsignedBigInteger("total_with_vat");
            $table->string("status");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->string("description");
            $table->unsignedBigInteger("unit_price");
            $table->unsignedBigInteger("quantity")
                ->default(1);
            $table->unsignedDecimal("vat_percentage", 10, 2)
                ->default(15.00);
            $table->unsignedBigInteger("total_without_vat");
            $table->unsignedBigInteger("vat_amount");
            $table->unsignedBigInteger("total_with_vat");
            $table->foreignId("invoice_id")
                ->constrained("invoices");
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId("invoice_id")
                ->nullable()
                ->constrained("invoices");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
