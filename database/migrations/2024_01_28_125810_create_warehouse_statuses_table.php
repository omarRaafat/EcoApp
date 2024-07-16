<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Warehouse;
use App\Models\WarehouseStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warehouse_id');
            $table->string('status')->default("accepted");
            $table->text('note')->nullable();
            $table->text('data')->nullable();
            $table->timestamps();

            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
        });

        $items = Warehouse::whereDoesntHave('getLastStatus')->get();
        foreach ($items as $key => $item) {
            WarehouseStatus::firstOrCreate([
                'warehouse_id' => $item->id,
            ],[
                'status' => Warehouse::ACCEPTED
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_statuses');
    }
};
