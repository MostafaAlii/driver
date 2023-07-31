<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('media_files_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_profiles_media_id')->constrained('driver_profiles_media')->cascadeOnDelete();
            $table->string('type');
            $table->enum('status', ['accept', 'reject', 'not_active'])->default('not_active');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('media_files_status');
    }
};