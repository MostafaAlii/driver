<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('driver_profiles_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_profile_id')->constrained('driver_profiles')->cascadeOnDelete();
            $table->string('license_front')->nullable();
            $table->string('license_back')->nullable();
            $table->string('car_license_front')->nullable();
            $table->string('car_license_back')->nullable();
            $table->string('personal_identification_front')->nullable();
            $table->string('personal_identification_back')->nullable();
            $table->string('criminal_record')->nullable();
            $table->string('car_front_side')->nullable();
            $table->string('car_back_side')->nullable();
            $table->string('car_right_side')->nullable();
            $table->string('car_left_side')->nullable();
            $table->string('car_inside')->nullable();
            $table->string('car_plate')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('driver_profiles_media');
    }
};