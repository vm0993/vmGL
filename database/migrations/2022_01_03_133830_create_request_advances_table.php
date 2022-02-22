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
            $table->unsignedBigInteger('personel_id');
            $table->string('code',20);
            $table->date('transaction_date');
            $table->string('description',180)->nullable();
            $table->decimal('request_amount',18,2)->default(0);
            $table->decimal('amount_approve',18,2)->default(0);
            $table->string('submit_hash',120)->nullable();
            $table->enum('status',['ACTIVE','SUBMIT','APPROVED','RELEASE','REPORTING','SUBMIT REPORT','APPROVED REPORT','REJECT REPORT','CANCEL','CLOSED'])->default('ACTIVE');
            $table->unsignedBigInteger('created_by');
            $table->bigInteger('updated_by')->default(0);
            $table->timestamps();

            $table->foreign('personel_id')->references('id')->on('personels')->onDelete('cascade');
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
