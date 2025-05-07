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
        Schema::table('goals', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('priority');
            $table->decimal('longitude', 10, 8)->nullable()->after('latitude');
            $table->string('location_name')->nullable()->after('longitude');
            $table->string('address')->nullable()->after('location_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude',
                'location_name',
                'address'
            ]);
        });
    }
};