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
        Schema::table('reviews', function (Blueprint $table) {
            $table->text("reason")->nullable();
            $table->unsignedBigInteger("admin_id")->nullable();
            $table->unsignedTinyInteger("admin_approved")->nullable();
            $table->boolean("reporting")->nullable();
            $table->text("admin_comment")->nullable();
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn("admin_id");
            $table->dropColumn("reason");
            $table->dropColumn("admin_approved");
            $table->dropColumn("reporting");
            $table->dropColumn("admin_comment");
        });
    }
};
