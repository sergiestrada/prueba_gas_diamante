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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')
                  ->constrained('providers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->decimal('amount', 10, 2)
                  ->comment('Monto del gasto');
            $table->string('concept', 255)
                  ->comment('Concepto del gasto');
            $table->date('date')
                  ->comment('Fecha del gasto');
            $table->text('description')
                  ->nullable()
                  ->comment('Descripción detallada');
            $table->timestamps();
            
            // Índices para optimización de consultas
            $table->index('date');
            $table->index('provider_id');
            $table->index(['provider_id', 'date']);
            $table->index('concept');
            
            // Índice compuesto para búsquedas comunes
            $table->index(['date', 'provider_id']);
        });
        
        // Agregar comentario a la tabla
        Schema::table('expenses', function (Blueprint $table) {
            $table->comment('Tabla de gastos asociados a proveedores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
