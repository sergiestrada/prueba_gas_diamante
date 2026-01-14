<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Provider;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  
        private array $concepts = [
        'Compra de materiales',
        'Servicios de mantenimiento',
        'Pago de servicios básicos',
        'Gastos de oficina',
        'Transporte y logística',
        'Combustible',
        'Pago de nómina',
        'Honorarios profesionales',
        'Publicidad y marketing',
        'Arrendamiento',
        'Seguros',
        'Impuestos',
        'Gastos bancarios',
        'Capacitación',
        'Reparaciones',
        'Software y licencias',
        'Suministros',
        'Viáticos',
        'Comisiones',
        'Donaciones',
    ];

    /**
     * Descripciones para hacer los datos más realistas
     */
    private array $descriptions = [
        'Pago mensual por servicios',
        'Compra realizada para proyecto específico',
        'Gasto operativo del mes',
        'Pago por servicios profesionales',
        'Inversión en equipo y materiales',
        'Gasto administrativo regular',
        'Pago de factura pendiente',
        'Inversión en mejoras',
        'Gasto extraordinario aprobado',
        'Compra de insumos necesarios',
        'Pago de alquiler mensual',
        'Servicio técnico contratado',
        'Mantenimiento preventivo',
        'Actualización de equipos',
        'Capacitación del personal',
        'Publicidad en redes sociales',
        'Transporte de mercancía',
        'Pago de impuestos municipales',
        'Seguro de equipo',
        'Licencia de software anual',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Desactivar restricciones de clave foránea temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Limpiar la tabla si ya existe data
        Expense::truncate();
        
        // Reactivar restricciones
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $providers = Provider::all();
        $faker = \Faker\Factory::create('es_ES'); // Español para datos más realistas
        
        // Fechas para generar datos en los últimos 3 meses
        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();
        
        $expenses = [];
        
        // Generar 50-60 gastos de manera más realista
        for ($i = 0; $i < 60; $i++) {
            $provider = $providers->random();
            $concept = $this->concepts[array_rand($this->concepts)];
            $description = $this->descriptions[array_rand($this->descriptions)];
            
            // Generar monto más realista basado en el concepto
            $amount = $this->generateRealisticAmount($concept);
            
            // Generar fecha aleatoria dentro del rango
            $date = $faker->dateTimeBetween($startDate, $endDate);
            
            // Crear el gasto
            Expense::create([
                'provider_id' => $provider->id,
                'amount' => $amount,
                'concept' => $concept,
                'date' => $date,
                'description' => $faker->boolean(70) ? $description : null, // 70% con descripción
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Mostrar progreso en consola
            if (($i + 1) % 10 === 0) {
                $this->command->info("Generados {$i} gastos de 60...");
            }
        }
        
        $this->command->info('✅ ExpenseSeeder completado: 60 gastos generados.');
        
        // Generar algunos gastos extras para proveedores específicos
        $this->createSpecialExpenses($providers);
    }
    
    /**
     * Genera montos realistas basados en el concepto del gasto
     */
    private function generateRealisticAmount(string $concept): float
    {
        $faker = \Faker\Factory::create();
        
        // Rangos de montos según el tipo de gasto
        $ranges = [
            'Compra de materiales' => [500, 5000],
            'Servicios de mantenimiento' => [200, 1500],
            'Pago de servicios básicos' => [100, 800],
            'Gastos de oficina' => [50, 500],
            'Transporte y logística' => [100, 1200],
            'Combustible' => [80, 600],
            'Pago de nómina' => [1000, 10000],
            'Honorarios profesionales' => [500, 3000],
            'Publicidad y marketing' => [200, 2000],
            'Arrendamiento' => [800, 3000],
            'Seguros' => [300, 1500],
            'Impuestos' => [500, 4000],
            'Gastos bancarios' => [20, 200],
            'Capacitación' => [300, 2500],
            'Reparaciones' => [150, 2000],
            'Software y licencias' => [100, 1500],
            'Suministros' => [50, 400],
            'Viáticos' => [200, 1000],
            'Comisiones' => [100, 2000],
            'Donaciones' => [100, 1000],
        ];
        
        // Buscar rango para el concepto específico o usar uno por defecto
        if (isset($ranges[$concept])) {
            $range = $ranges[$concept];
        } else {
            $range = [100, 2000]; // Rango por defecto
        }
        
        return $faker->randomFloat(2, $range[0], $range[1]);
    }
    
    /**
     * Crea gastos especiales para algunos proveedores
     */
    private function createSpecialExpenses($providers): void
    {
        $faker = \Faker\Factory::create('es_ES');
        
        // Gastos recurrentes mensuales
        $monthlyExpenses = [
            'Alquiler de oficina' => 2500.00,
            'Servicio de internet' => 120.00,
            'Servicio eléctrico' => 350.00,
            'Servicio de agua' => 80.00,
            'Nómina fija' => 8500.00,
        ];
        
        // Generar gastos recurrentes para los últimos 3 meses
        foreach ($monthlyExpenses as $concept => $amount) {
            $provider = $providers->where('name', 'like', '%Proveedor A%')->first();
            
            if ($provider) {
                $start = Carbon::now()->subMonths(3);
                
                for ($month = 0; $month < 3; $month++) {
                    $date = $start->copy()->addMonths($month)->day(rand(1, 28));
                    
                    Expense::create([
                        'provider_id' => $provider->id,
                        'amount' => $amount,
                        'concept' => $concept,
                        'date' => $date,
                        'description' => "Pago mensual de {$concept} - " . $date->format('F Y'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        // Gastos extraordinarios
        $extraordinaryExpenses = [
            ['concept' => 'Compra de equipo nuevo', 'amount' => 8500.00, 'provider' => 'Proveedor B'],
            ['concept' => 'Reparación de maquinaria', 'amount' => 3200.50, 'provider' => 'Proveedor C'],
            ['concept' => 'Software de gestión', 'amount' => 1500.00, 'provider' => 'Proveedor D'],
            ['concept' => 'Capacitación intensiva', 'amount' => 2800.00, 'provider' => 'Proveedor E'],
        ];
        
        foreach ($extraordinaryExpenses as $expense) {
            $provider = $providers->where('name', 'like', "%{$expense['provider']}%")->first();
            
            if ($provider) {
                $date = Carbon::now()->subDays(rand(10, 60));
                
                Expense::create([
                    'provider_id' => $provider->id,
                    'amount' => $expense['amount'],
                    'concept' => $expense['concept'],
                    'date' => $date,
                    'description' => "{$expense['concept']} - Gasto extraordinario aprobado",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        $this->command->info('✅ Gastos especiales creados: mensuales y extraordinarios.');
    }
}
