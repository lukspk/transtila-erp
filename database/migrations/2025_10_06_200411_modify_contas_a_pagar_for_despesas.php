<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('conta_pagars', function (Blueprint $table) {
            $table->foreignId('despesa_id')->after('entrega_id')->constrained('despesas');
        });
    }

    public function down(): void
    {
        Schema::table('conta_pagars', function (Blueprint $table) {
            $table->dropForeign(['despesa_id']);
            $table->dropColumn('despesa_id');
            $table->string('descricao')->after('entrega_id');
        });
    }

};
