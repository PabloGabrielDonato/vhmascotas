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
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha_nacimiento');
            $table->string('raza');
            $table->string('especie');
            $table->string('avatar')->nullable();
            $table->string('direccion');
            $table->string('alergias');
            $table->string('observaciones'); 
            $table->string('sociable_perros'); 
            $table->string('sociable_humanos'); 
            $table->string('castracion'); 
            $table->date('sextuple');
            $table->date('antirrabica');
            $table->date('bordetella');

            $table->enum('state', ['activo', 'inactivo'])->default('activo');
            $table->foreignId('dueños_id')
                ->nullable()
                ->constrained('dueños')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
