<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('trip_types', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('description', 255)->nullable();
            $table->string('name', 150)->unique();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('trip_types');
    }
};
