<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id')->default(0);
            $table->string('code',20);
            $table->date('transaction_date');
            $table->string('description',180)->nullable();
            $table->decimal('total',18,2)->default(0);
            $table->integer('status')->default(0);
            $table->integer('posting')->default(0);
            $table->integer('is_recurring')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('jurnals');
    }
}
