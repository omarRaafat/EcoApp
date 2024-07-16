<?php

use App\Models\PostHarvestServicesDepartmentField;
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
        Schema::create('post_harvest_services_department_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type',['text-area','checkbox','dropdown-list','integer','from-to']);
            $table->boolean('is_required')->default(false);
            $table->enum('status',[PostHarvestServicesDepartmentField::ACTIVE,PostHarvestServicesDepartmentField::NOT_ACTIVE])
            ->default('active');
            $table->boolean('depends_on_price')->default(false);
            $table->foreignId('post_harvest_id')
            ->constrained('post_harvest_services_departments')
            ->cascadeOnDelete();
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
        Schema::dropIfExists('post_harvest_services_department_fields');
    }
};
