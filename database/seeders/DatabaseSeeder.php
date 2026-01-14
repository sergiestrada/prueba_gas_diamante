<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando proceso de seeding...');
        $this->command->line('================================');
        
        // Desactivar restricciones de clave foránea temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Limpiar tablas en orden correcto (primero las dependientes)
        $this->command->info('🧹 Limpiando tablas existentes...');
        
        DB::table('expenses')->truncate();
        DB::table('incomes')->truncate();
        DB::table('providers')->truncate();
        
        // Reactivar restricciones
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Ejecutar seeders en orden específico
        $this->call([
            ProviderSeeder::class,
            IncomeSeeder::class,
            ExpenseSeeder::class,
        ]);
        
        // Crear usuario de prueba si no existe
        $this->createTestUser();
        
        // Resumen de datos generados
        $this->showSummary();
        
        $this->command->info('✅ Seeding completado exitosamente!');
        $this->command->line('================================');
    }
    
    /**
     * Crear usuario de prueba para acceder al sistema
     */
    private function createTestUser(): void
    {
        if (!\App\Models\User::where('email', 'admin@repsa.com')->exists()) {
            \App\Models\User::create([
                'name' => 'Administrador',
                'email' => 'admin@repsa.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('👤 Usuario de prueba creado:');
            $this->command->line('   Email: admin@repsa.com');
            $this->command->line('   Contraseña: password123');
        }
    }
    
    /**
     * Mostrar resumen de datos generados
     */
    private function showSummary(): void
    {
        $this->command->line('');
        $this->command->info('📊 RESUMEN DE DATOS GENERADOS:');
        $this->command->line('================================');
        
        $providerCount = \App\Models\Provider::count();
        $incomeCount = \App\Models\Income::count();
        $expenseCount = \App\Models\Expense::count();
        
        $totalIncome = \App\Models\Income::sum('amount');
        $totalExpense = \App\Models\Expense::sum('amount');
        $totalUtility = $totalIncome - $totalExpense;
        
        $this->command->line("🏢 Proveedores: {$providerCount} registros");
        $this->command->line("💰 Ingresos: {$incomeCount} registros - Total: $" . number_format($totalIncome, 2));
        $this->command->line("💸 Gastos: {$expenseCount} registros - Total: $" . number_format($totalExpense, 2));
        $this->command->line("📈 Utilidad Bruta: $" . number_format($totalUtility, 2));
        
        // Estadísticas por proveedor
        $this->command->line('');
        $this->command->info('📋 ESTADÍSTICAS POR PROVEEDOR:');
        $this->command->line('================================');
        
        $providers = \App\Models\Provider::withCount(['incomes', 'expenses'])
            ->withSum('incomes', 'amount')
            ->withSum('expenses', 'amount')
            ->orderBy('name')
            ->get();
            
        foreach ($providers as $provider) {
            $utility = ($provider->incomes_sum_amount ?? 0) - ($provider->expenses_sum_amount ?? 0);
            $utilityColor = $utility >= 0 ? 'green' : 'red';
            
            $this->command->line(sprintf(
                "  %-20s | Ingresos: %6s | Gastos: %6s | Utilidad: %8s",
                substr($provider->name, 0, 20),
                "$" . number_format($provider->incomes_sum_amount ?? 0, 0),
                "$" . number_format($provider->expenses_sum_amount ?? 0, 0),
                "<fg={$utilityColor}>$" . number_format($utility, 0) . "</>"
            ));
        }
        
        $this->command->line('');
        $this->command->info('🔧 DATOS DE PRUEBA PARA FILTROS:');
        $this->command->line('================================');
        $this->command->line('📅 Fechas disponibles: Últimos 3 meses');
        $this->command->line('👥 Proveedores: 10 diferentes');
        $this->command->line('💼 Conceptos variados: Más de 20 diferentes');
        $this->command->line('💰 Montos realistas: Desde $20 hasta $10,000');
    }
}
