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
        Schema::table('component_categories', function (Blueprint $table) {
            $table->foreignId('module_id')->nullable()->constrained()->after('name');
            $table->foreignId('profile_id')->constrained()->after('module_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('component_categories', function (Blueprint $table) {
            $table->dropColumn('module_id');
            $table->dropColumn('profile_id');
        });
    }
};
