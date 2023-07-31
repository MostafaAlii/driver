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
        Schema::create('driver_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('lan')->nullable();
            $table->text('lat')->nullable();
            $table->enum('type',['online','offline']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('trip',['empty','in_trip'])->default('empty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_activities');
    }
};
