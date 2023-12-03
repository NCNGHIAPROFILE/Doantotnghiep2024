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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('MaSV', 20);
            $table->string('FistNameUser', 255);
            $table->string('LastNameUser', 10);
            $table->string('Class', 20);
            $table->string('AddressUser', 255)->nullable();
            $table->string('Phone', 11)->nullable();
            $table->string('email', 70);
            $table->string('password', 255);
            $table->text('Token')->nullable();
            $table->string('ImageUser', 255)->nullable();
            $table->string('role')->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
