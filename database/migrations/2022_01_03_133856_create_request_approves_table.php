<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestApprovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_approves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_advance_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount',18,2)->default(0);
            $table->string('note',80)->nullable();
            $table->timestamps();

            $table->foreign('request_advance_id')->references('id')->on('request_advances')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_approves');
    }
}
