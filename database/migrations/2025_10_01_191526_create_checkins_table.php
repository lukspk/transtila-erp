<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            // Adicione estas 4 linhas abaixo
            $table->foreignId('entrega_id')->constrained('entregas')->onDelete('cascade');
            $table->foreignId('motorista_id')->constrained('motoristas')->onDelete('cascade');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
