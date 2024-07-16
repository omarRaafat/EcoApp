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
        Schema::table('recipes', function (Blueprint $table) {
            $table->text('short_desc');
            $table->boolean('most_visited') ;
        });
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->text('short_desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('short_desc');
            $table->dropColumn('most_visited');
        });
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('short_desc');
        });
    }
};
