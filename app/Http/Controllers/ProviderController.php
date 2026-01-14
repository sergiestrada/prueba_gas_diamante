<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Http\Request\StoreProviderRequest;
use App\Http\Request\UpdateProviderRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    
     public function index(Request $request)
    {
        $query = Provider::withCount(['incomes', 'expenses'])
            ->withSum('incomes', 'amount')
            ->withSum('expenses', 'amount')
            ->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('rfc', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $providers = $query->paginate(15);
        
        return view('providers.index', compact('providers'));
    }

    public function create()
    {
        return view('providers.create');
    }

  
    public function store(StoreProviderRequest $request)
    {
        try {
            DB::beginTransaction();
            
            Provider::create($request->validated());
            
            DB::commit();
            
            return redirect()->route('providers.index')
                ->with('success', 'Proveedor creado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al crear el proveedor: ' . $e->getMessage())
                ->withInput();
        }
    }

 
      public function edit(Provider $provider)  
    {
        // $provider ya es una instancia del modelo
        return view('providers.edit', compact('provider'));
    }
    
 
    public function update(UpdateProviderRequest $request, Provider $provider)
    {
        $provider->update($request->validated());
        
        return redirect()->route('providers.index')
            ->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy($id) 
    {
        try {
            DB::beginTransaction();
            
            $provider = Provider::findOrFail($id);
            $provider->incomes()->delete();
            $provider->expenses()->delete();
            $provider->delete();
            
            DB::commit();
            
            return redirect()->route('providers.index')
                ->with('success', 'Proveedor y todos sus registros asociados eliminados exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al eliminar el proveedor: ' . $e->getMessage());
        }
    }
}