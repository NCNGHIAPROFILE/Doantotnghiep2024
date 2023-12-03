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
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('MaTicket', 20)->nullable();
            $table->String('MaSV', 20);
            $table->String('MaSach', 10);
            $table->String('MaAdmin', 10)->nullable();
            $table->datetime('DateCreateTicket');
            $table->datetime('DateAcceptTiket')->nullable();
            $table->datetime('DateGiveBack')->nullable();
            $table->integer('StatusTicket');
            $table->string('Note', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
