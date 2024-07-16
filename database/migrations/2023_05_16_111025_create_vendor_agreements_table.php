<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\VendorAgreementEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_agreements', function (Blueprint $table) {
            $table->id();
            $table->string('agreement_pdf');
            $table->unsignedBigInteger("vendor_id");
            $table->enum("status", VendorAgreementEnum::getStatuses())->default(VendorAgreementEnum::PENDING);
            $table->unsignedBigInteger("approved_by")->nullable();
            $table->string('approved_pdf')->nullable();
            $table->dateTime('approved_at')->nullable();
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
        Schema::dropIfExists('vendor_agreements');
    }
};
