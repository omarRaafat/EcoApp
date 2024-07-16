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
       try {
        Schema::table('favorite_products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
       } catch (\Throwable $th) {
        //throw $th;
       }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favorite_products', function (Blueprint $table) {
            //
        });
    }
};
