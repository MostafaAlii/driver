<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->foreignId('car_type_id')->constrained('car_types')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropForeign('car_type_id');
        });
    }
};
