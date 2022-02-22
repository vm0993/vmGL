<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categori_id');
            $table->string('code',12);
            $table->string('name',40);
            $table->enum('type_id',['COST','INVOICE','OR'])->default('COST');
            $table->integer('wip_id')->default(0);
            $table->integer('cogs_id')->default(0);
            $table->integer('expense_id')->default(0);
            $table->integer('status')->default(0)->comment('0: Active, 1: Suspend');
            $table->unsignedBigInteger('created_by');
            $table->bigInteger('updated_by')->default(0);
            $table->timestamps();

            $table->foreign('categori_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cost_charges');
    }
}
