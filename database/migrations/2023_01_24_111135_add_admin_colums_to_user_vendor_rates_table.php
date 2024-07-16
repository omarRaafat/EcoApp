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
        Schema::table('user_vendor_rates', function (Blueprint $table) {
            $table->unsignedBigInteger("admin_id")->nullable();
            $table->unsignedTinyInteger("admin_approved")->nullable();
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
        Schema::table('user_vendor_rates', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn("admin_id");
            $table->dropColumn("admin_approved");
            $table->dropColumn("admin_comment");
        });
    }
};
