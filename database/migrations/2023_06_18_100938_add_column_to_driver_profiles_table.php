<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('driver_profiles', function (Blueprint $table) {
            $table->foreignId('vehicle_type_id')->nullable()->constrained('vehicle_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('car_make_id')->nullable()->constrained('car_makes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('car_model_id')->nullable()->constrained('car_models')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('car_color')->nullable();
            $table->string('car_number', 50)->nullable();
            $table->string('nationality_id', 50)->nullable();
            $table->string('today_trip_count', 50)->nullable();
            $table->string('total_accept', 50)->nullable();
            $table->string('total_reject', 50)->nullable();
            $table->string('acceptance_ratio')->nullable();
            $table->timestamp('last_trip_date')->nullable();
            $table->boolean('status')->default(false);
        });
    }
    
    public function down(): void {
        $columns = ['vehicle_type_id', 'car_make_id', 'car_model_id', 'car_color', 'nationality_id', 'car_number', 'today_trip_count', 'total_accept', 'total_reject', 'acceptance_ratio', 'last_trip_date', 'status'];
        Schema::table('driver_profiles', function (Blueprint $table) use ($columns) {
            foreach ($columns as $column) {
                $table->dropIfExists($column);
            }
        });
    }
};
