<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Provider;
use App\Http\Request\StoreExpenseRequest;
use App\Http\Request\UpdateExpenseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::with('provider')
            ->latest('date');
        
        // Filtro por fecha
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }
        
        // Filtro por proveedor
        if ($request->filled('provider_id')) {
            $query->byProvider($request->provider_id);
        }
        
        // Búsqueda
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        $expenses = $query->paginate(15);
        $providers = Provider::orderBy('name')->get();
        
        // Totales
        $totalAmount = $expenses->sum('amount');
        
        return view('expenses.index', compact('expenses', 'providers', 'totalAmount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $providers = Provider::orderBy('name')->get();
        return view('expenses.create', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $expense = Expense::create($request->validated());
            
            DB::commit();
            
            return redirect()->route('expenses.index')
                ->with('success', 'Gasto registrado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al registrar el gasto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $providers = Provider::orderBy('name')->get();
        return view('expenses.edit', compact('expense', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        try {
            DB::beginTransaction();
            
            $expense->update($request->validated());
            
            DB::commit();
            
            return redirect()->route('expenses.index')
                ->with('success', 'Gasto actualizado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al actualizar el gasto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        try {
            DB::beginTransaction();
            
            $expense->delete();
            
            DB::commit();
            
            return redirect()->route('expenses.index')
                ->with('success', 'Gasto eliminado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al eliminar el gasto: ' . $e->getMessage());
        }
    }

    /**
     * Exportar gastos a Excel o PDF.
     */
    public function export(Request $request)
    {
        $query = Expense::with('provider')
            ->latest('date');
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }
        
        if ($request->filled('provider_id')) {
            $query->byProvider($request->provider_id);
        }
        
        $expenses = $query->get();
        
        // Implementar exportación según necesidad
        
        return response()->json([
            'data' => $expenses,
            'total' => $expenses->sum('amount')
        ]);
    }
}
