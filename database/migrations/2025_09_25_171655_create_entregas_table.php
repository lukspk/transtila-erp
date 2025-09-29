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
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();

            $table->string('modelo'); // ok
            $table->string('serie'); // antes era integer
            $table->string('numero'); // antes era integer
            $table->string('chave_acesso', 60)->unique();
            $table->timestamp('data_hora_emissao');
            $table->string('protocolo_autorizacao')->nullable();
            $table->string('modal');
            $table->string('uf_carregamento', 2);
            $table->string('uf_descarregamento', 2);
            $table->integer('qtd_cte');
            $table->integer('qtd_nfe');
            $table->decimal('peso_total_kg', 15, 2);
            $table->decimal('valor_total_carga', 15, 2);

            // Emitente
            $table->string('emitente_nome')->default('TRANSTILA SOLUCOES');
            $table->string('emitente_cnpj', 18);
            $table->string('emitente_ie', 20);
            $table->string('emitente_rntrc', 20);
            $table->string('emitente_logradouro');
            $table->string('emitente_numero_logradouro');
            $table->string('emitente_bairro');
            $table->string('emitente_municipio');
            $table->string('emitente_uf', 2);
            $table->string('emitente_cep', 12);


            // Veículo
            $table->string('veiculo_placa_principal', 7);
            $table->string('veiculo_rntrc_principal', 20);
            $table->string('veiculo_placa_secundaria', 7)->nullable();
            $table->string('veiculo_rntrc_secundario', 20)->nullable();

            // Vincular motorista
            $table->foreignId('motorista_id')->constrained()->onDelete('cascade');

            // Seguro
            $table->string('seguro_responsavel_cnpj', 18);
            $table->string('seguro_apolice');
            $table->string('seguro_averbacao');

            // CIOT
            $table->string('ciot_responsavel_cnpj', 18);
            $table->string('ciot_numero');

            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};
