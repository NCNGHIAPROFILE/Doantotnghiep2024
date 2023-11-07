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
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('MaSach', 20)->nullable();
            $table->string('NameBook', 255);
            $table->string('Author', 70);
            $table->integer('MaAdmin');
            $table->string('Category', 70);
            $table->integer('Type');
            $table->integer('MaProducer');
            $table->date('YearPublish');
            $table->integer('Quantity');
            $table->string('Content', 255)->nullable();
            $table->integer('Status');
            $table->string('Picture', 255)->nullable();
            $table->integer('Sum_Quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
