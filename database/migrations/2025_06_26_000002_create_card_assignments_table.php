<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('card_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendant_id')->constrained();
            $table->foreignId('card_id')->constrained();
            $table->dateTime('assigned_from');
            $table->dateTime('assigned_to')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('card_assignments');
    }
};
