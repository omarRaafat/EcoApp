<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('line_shipping_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('city_to_id');
            $table->float('dyna');
            $table->float('lorry');
            $table->float('truck');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('line_shipping_prices');
    }
};
