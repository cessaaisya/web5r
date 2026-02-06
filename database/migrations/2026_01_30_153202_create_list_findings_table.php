<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('list_findings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_activity_id')->constrained('daily_activities')->onDelete('cascade');
            $table->enum('level', ['s', 'q', 'p', 'c', 'hr']);
            $table->text('countermeasure');
            $table->date('countermeasure_schedule');
            $table->enum('progress', ['pending', 'in_progress', 'completed', 'cancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_findings');
    }
};
