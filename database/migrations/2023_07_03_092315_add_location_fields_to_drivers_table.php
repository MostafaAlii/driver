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
        Schema::table('drivers', function (Blueprint $table) {
            $table->decimal('lan', 10, 8)->nullable()->after('password');
            $table->decimal('lat', 11, 8)->nullable()->after('lan');
            $table->boolean('online')->default(false)->after('lat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn('lan');
            $table->dropColumn('lat');
            $table->dropColumn('online');
        });
    }
};
