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
        Schema::table('users',function(Blueprint $table){
            $table->string('college')->nullable();
            $table->text('about_me')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->tinyInteger('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users',function(Blueprint $table){
            $table->dropColumn('college');
            $table->dropColumn('about_me');
            $table->dropColumn('dob');
            $table->dropColumn('gender');
            $table->dropColumn('is_active');
        });
    }
};
