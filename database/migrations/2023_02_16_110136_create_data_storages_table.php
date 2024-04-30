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
        Schema::create('drop_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Card_id');
            $table->string('Card_number');
            $table->string('Sequence')->unique();
            $table->string('Total');
            $table->string('DateTime');
            $table->boolean('shift');
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
        Schema::dropIfExists('data_storages');
    }
};
