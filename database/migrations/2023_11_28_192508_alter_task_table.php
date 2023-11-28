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
        Schema::table('tasks',function(Blueprint $table){
            $table->tinyInteger('is_progress')->default(0);
            $table->tinyInteger('is_completed')->default(0);
            $table->tinyInteger('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks',function(Blueprint $table){
            $table->removeColumn('is_progress');
            $table->removeColumn('is_completed');
            $table->removeColumn('is_deleted');
        });
    }
};
