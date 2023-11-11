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
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('MaAdmin', 20)->nullable();
            $table->string('NameAdmin', 70);
            $table->string('AddressAdmin', 255);
            $table->string('Phone', 11);
            $table->string('email', 70);
            $table->string('password', 255);
            $table->string('Token', 255)->nullable();
            $table->string('ImageAdmin', 255)->nullable();
            $table->string('role')->default('admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
