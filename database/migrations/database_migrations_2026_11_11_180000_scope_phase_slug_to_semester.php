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
        Schema::table('fyp_phases', function (Blueprint $table) {
            $table->dropUnique('fyp_phases_slug_unique');
            $table->unique(['semester', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fyp_phases', function (Blueprint $table) {
            $table->dropUnique('fyp_phases_semester_slug_unique');
            $table->unique('slug');
        });
    }
};