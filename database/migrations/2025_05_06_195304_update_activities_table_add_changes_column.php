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
        Schema::table('activities', function (Blueprint $table) {
            if (!Schema::hasColumn('activities', 'changes')) {
                $table->json('changes')->nullable();
            }
            if (!Schema::hasColumn('activities', 'type')) {
                $table->string('type')->nullable();
            }
            if (!Schema::hasColumn('activities', 'description')) {
                $table->string('description')->nullable();
            }
            if (!Schema::hasColumn('activities', 'ip_address')) {
                $table->string('ip_address')->nullable();
            }
            if (!Schema::hasColumn('activities', 'user_agent')) {
                $table->string('user_agent')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'changes')) {
                $table->dropColumn('changes');
            }
            if (Schema::hasColumn('activities', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('activities', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('activities', 'ip_address')) {
                $table->dropColumn('ip_address');
            }
            if (Schema::hasColumn('activities', 'user_agent')) {
                $table->dropColumn('user_agent');
            }
        });
    }
};
