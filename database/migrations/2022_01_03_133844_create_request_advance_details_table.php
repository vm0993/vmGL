<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestAdvanceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_advance_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_advance_id');
            $table->unsignedBigInteger('cost_charge_id');
            $table->decimal('amount',18,2)->default(0);
            $table->string('note',80)->nullable();
            $table->timestamps();

            $table->foreign('request_advance_id')->references('id')->on('request_advances')->onDelete('cascade');
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
        Schema::dropIfExists('request_advance_details');
    }
}
