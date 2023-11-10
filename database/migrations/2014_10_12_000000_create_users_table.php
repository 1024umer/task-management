<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->integer('role_id')->index();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->bigInteger('country_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@taskmanagement.com',
            'password' => Hash::make('12345678'),
            'role_id' => 1,
            'phone' => '34235434',
            'country_id'=>'12',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
