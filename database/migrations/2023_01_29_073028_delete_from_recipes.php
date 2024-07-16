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
        
        if (Schema::hasColumn('recipes', 'image')){
            Schema::table('recipes', function (Blueprint $table) {
                $table->dropColumn('image');
            });

        }
        
        if (Schema::hasColumn('blog_posts', 'image')){
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->dropColumn('image');
            });

        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
};
