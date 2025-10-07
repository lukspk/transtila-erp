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
        Schema::create('financeiros', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['PAGAR', 'RECEBER']);
            $table->string('nome');
            $table->text('descricao');

            //$table->foreignId('entrega_id')->nullable()->constrained('entregas')->onDelete('set null');
            $table->foreignId('financeiro_categoria_id')->nullable()->constrained('financeiro_categorias')->onDelete('set null');

            $table->decimal('valor', 10, 2);
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->enum('status', ['Pendente', 'Pago', 'Atrasado', 'Cancelado'])->default('Pendente');
            $table->text('observacoes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiros');
    }
};
