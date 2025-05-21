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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('id');
            $table->enum('role', ['provider', 'station_admin', 'client_user'])->default('client_user')->after('password');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('role');
            $table->unsignedBigInteger('station_admin_id')->nullable()->after('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->foreign('station_admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['station_admin_id']);
            $table->dropColumn(['client_id', 'role', 'status', 'station_admin_id']);
        });
        Schema::dropIfExists('clients');
    }
};
