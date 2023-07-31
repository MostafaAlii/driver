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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('open_door')->nullable();
            $table->string('waiting_price')->nullable();
            $table->string('country_tax')->nullable();
            $table->string('kilo_price')->nullable();
            $table->string('ocean')->nullable();
            $table->string('company_commission')->nullable();
            $table->string('company_tax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['open_door', 'waiting_price', 'country_tax', 'kilo_price', 'ocean', 'company_commission', 'company_tax']);
        });
    }
};
