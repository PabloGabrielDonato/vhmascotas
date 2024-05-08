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
        Schema::create('jardincitos', function (Blueprint $table) {
            $table->id();
            $table->enum('dia', ['lunes', 'miercoles','sabado']);
            $table->time('hora_inicio');
            $table->time('hora_finalizacion');
            $table->enum('state', ['activo', 'inactivo'])->default('activo'); 
            $table->foreignId('mascotas_id')
                ->constrained('mascotas')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jardincitos');
    }
};
