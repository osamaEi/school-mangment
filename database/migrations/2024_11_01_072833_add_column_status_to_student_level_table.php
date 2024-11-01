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
        Schema::table('student_level', function (Blueprint $table) {
            $table->timestamp('enrolled_at')
            ->nullable()
            ->after('status');
            
      $table->timestamp('completed_at')
            ->nullable()
            ->after('enrolled_at');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_level', function (Blueprint $table) {
            //
        });
    }
};
