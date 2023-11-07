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
            $table->char('MaSV', 10);
            $table->char('MaSach', 10);
            $table->char('MaAdmin', 10);
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
