<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_advances', function (Blueprint $table) {
            $table->id();
            $table->string('code',20);
            $table->date('transaction_date');
            $table->string('description',180)->nullable();
            $table->decimal('request_amount',18,2)->default(0);
            $table->decimal('amount_approve',18,2)->default(0);
            $table->integer('status')->default(0)->comment('0 : Draft, 1: Submit, 2: Verified, 3: Approve, 4: Release, 5: Report Draft, 6: Approve Report, 7: Cancel');
            $table->unsignedBigInteger('created_by');
            $table->bigInteger('updated_by')->default(0);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_advances');
    }
}
