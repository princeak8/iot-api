<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('module_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text("description")->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', array('--class' => 'ModuleTypes'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_types');
    }
};
