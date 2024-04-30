<?php

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
        Schema::create('cashier_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attendant_id');
            $table->string('shift');
            $table->Date('date');
            $table->string('total');
            $table->string('expected');
            $table->string('difference');
           // default value of recovery is 0
             $table->string('recovery')->default(0);
            //coins also nullable
            $table->string('coins')->nullable();
            $table->string('amount')->nullable();
            $table->enum('status', ['complete', 'incomplete'])->default('incomplete');
            $table->text('comment')->nullable();

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
        Schema::dropIfExists('transactions');
    }
};
