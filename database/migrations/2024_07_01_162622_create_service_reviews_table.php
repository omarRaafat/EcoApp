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
        Schema::create('service_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('rate')->default(1);
            $table->text('comment')->nullable();
            $table->foreignId('user_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->text('reason')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('admin_approved')->nullable();
            $table->tinyInteger('reporting')->nullable();
            $table->text('admin_comment')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_reviews');
    }
};
