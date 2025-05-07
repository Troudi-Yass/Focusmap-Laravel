<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, modify the status column to be a string instead of enum
        Schema::table('goals', function (Blueprint $table) {
            $table->string('status')->default('not_started')->change();
        });

        // Update existing records to use new status values
        DB::table('goals')->where('status', 'in_progress')->update(['status' => 'just_started']);
        
        // Update the Goal model status values in the database
        DB::statement("UPDATE goals SET 
            status = CASE 
                WHEN progress <= 25 THEN 'just_started'
                WHEN progress <= 50 THEN 'on_track'
                WHEN progress <= 75 THEN 'in_progress'
                WHEN progress < 100 THEN 'almost_done'
                ELSE 'completed'
            END");
    }

    public function down()
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->string('status')->default('not_started')->change();
        });
        
        // Revert to original status values
        DB::table('goals')->whereIn('status', ['just_started', 'on_track', 'almost_done'])
            ->update(['status' => 'in_progress']);
    }
};