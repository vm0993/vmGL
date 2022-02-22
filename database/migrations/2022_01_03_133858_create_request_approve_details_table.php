<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestApproveDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_approve_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_approve_id');
            $table->unsignedBigInteger('cost_charge_id');
            $table->decimal('approve_amount',18,2)->default(0);
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->foreign('request_approve_id')->references('id')->on('request_approves')->onDelete('cascade');
            $table->foreign('cost_charge_id')->references('id')->on('cost_charges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_approve_details');
    }
}
