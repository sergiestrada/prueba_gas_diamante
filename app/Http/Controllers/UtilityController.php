<?php

namespace App\Http\Controllers;


use App\Models\Provider;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Provider::with(['incomes', 'expenses']);
        
        // Filtros
        if ($request->filled('start_date')) {
            $query->whereHas('incomes', function($q) use ($request) {
                $q->where('date', '>=', $request->start_date);
            })->orWhereHas('expenses', function($q) use ($request) {
                $q->where('date', '>=', $request->start_date);
            });
        }
        
        if ($request->filled('end_date')) {
            $query->whereHas('incomes', function($q) use ($request) {
                $q->where('date', '<=', $request->end_date);
            })->orWhereHas('expenses', function($q) use ($request) {
                $q->where('date', '<=', $request->end_date);
            });
        }
        
        if ($request->filled('provider_id')) {
            $query->where('id', $request->provider_id);
        }
        
        $providers = $query->get();
        
        $totalIncome = $providers->sum('total_income');
        $totalExpense = $providers->sum('total_expense');
        $totalUtility = $totalIncome - $totalExpense;
        
        return view('utilities.index', compact(
            'providers', 
            'totalIncome', 
            'totalExpense', 
            'totalUtility'
        ));
    }
}
