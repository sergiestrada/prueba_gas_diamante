<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Provider;
use App\Http\Request\StoreIncomeRequest;
use App\Http\Request\UpdateIncomeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{

    public function index(Request $request)
    {
       $query = Income::with('provider')->latest('date');
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }
        
        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('concept', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $incomes = $query->paginate(15);
        $providers = Provider::orderBy('name')->get();
        
      
        $totalAmount = $incomes->sum('amount');
        
        return view('incomes.index', compact('incomes', 'providers', 'totalAmount'));
    }
    
    public function create()
    {
        $providers = Provider::orderBy('name')->get();
        return view('incomes.create', compact('providers'));
    }

    public function store(StoreIncomeRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $income = Income::create($request->validated());
            
            DB::commit();
            
            return redirect()->route('incomes.index')
                ->with('success', 'Ingreso registrado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al registrar el ingreso: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Income $income)
    {
        $providers = Provider::orderBy('name')->get();
        return view('incomes.edit', compact('income', 'providers'));
    }
    public function update(UpdateIncomeRequest $request, Income $income)
    {
        try {
            DB::beginTransaction();
            
            $income->update($request->validated());
            
            DB::commit();
            
            return redirect()->route('incomes.index')
                ->with('success', 'Ingreso actualizado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al actualizar el ingreso: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Income $income)
    {
        try {
            DB::beginTransaction();
            
            $income->delete();
            
            DB::commit();
            
            return redirect()->route('incomes.index')
                ->with('success', 'Ingreso eliminado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al eliminar el ingreso: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $query = Income::with('provider')
            ->latest('date');
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }
        
        if ($request->filled('provider_id')) {
            $query->byProvider($request->provider_id);
        }
        
        $incomes = $query->get();
               
        return response()->json([
            'data' => $incomes,
            'total' => $incomes->sum('amount')
        ]);
    }
}
