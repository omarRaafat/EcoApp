<?php

use App\Enums\DomesticZone;
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
        Schema::table('domestic_zones', function (Blueprint $table) {
            $table->dropColumn("type");
        });
        Schema::table('domestic_zones', function (Blueprint $table) {
            $table->enum("type", DomesticZone::getTypesArray())->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domestic_zones', function (Blueprint $table) {
        });
    }
};
