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
        Schema::create('financeiro_parcelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financeiro_id')->constrained('financeiros')->onDelete('cascade');
            $table->integer('numero_parcela');
            $table->decimal('valor_parcela', 10, 2);
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->enum('status', ['Pendente', 'Pago', 'Atrasado'])->default('Pendente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiro_parcelas');
    }
};
