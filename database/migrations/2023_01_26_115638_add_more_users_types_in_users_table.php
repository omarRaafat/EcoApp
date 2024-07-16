<?php

use App\Enums\UserTypes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types = collect(UserTypes::getListOfTypes())->map(fn($e)=>'"'.$e.'"')->implode(',');
        DB::statement("ALTER TABLE `users` CHANGE `type` `type` ENUM($types);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `users` CHANGE `type` `type` ENUM('admin', 'vendor', 'customer');"); 
    }
};
