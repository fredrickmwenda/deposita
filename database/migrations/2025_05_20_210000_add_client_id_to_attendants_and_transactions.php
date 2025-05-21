<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('attendants', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('Card_number');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('attendant_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::table('attendants', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};
