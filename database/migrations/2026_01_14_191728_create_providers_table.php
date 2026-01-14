<?php
// database/migrations/2025_01_15_000001_create_providers_table.php
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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)
                  ->unique()
                  ->comment('Nombre del proveedor');
            $table->string('contact_person', 255)
                  ->nullable()
                  ->comment('Persona de contacto');
            $table->string('email', 255)
                  ->nullable()
                  ->comment('Correo electrónico');
            $table->string('phone', 50)
                  ->nullable()
                  ->comment('Teléfono de contacto');
            $table->string('address', 500)
                  ->nullable()
                  ->comment('Dirección física');
            $table->string('rfc', 20)
                  ->nullable()
                  ->comment('RFC para facturación');
            $table->enum('status', ['active', 'inactive', 'pending'])
                  ->default('active')
                  ->comment('Estado del proveedor');
            $table->text('notes')
                  ->nullable()
                  ->comment('Notas adicionales');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para optimización
            $table->index('name');
            $table->index('status');
            $table->index('created_at');
        });
        
        // Agregar comentario descriptivo
        Schema::table('providers', function (Blueprint $table) {
            $table->comment('Tabla de proveedores con información de contacto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};