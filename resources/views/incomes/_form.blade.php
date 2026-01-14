
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 
    <div>
        <label for="provider_id" class="block text-sm font-medium text-gray-700 mb-1">
            Proveedor <span class="text-red-500">*</span>
        </label>
        <select name="provider_id" id="provider_id" required
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">Seleccione un proveedor</option>
            @foreach($providers as $provider)
                <option value="{{ $provider->id }}" {{ old('provider_id', $income->provider_id ?? '') == $provider->id ? 'selected' : '' }}>
                    {{ $provider->name }}
                </option>
            @endforeach
        </select>
        @error('provider_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>


    <div>
        <label for="concept" class="block text-sm font-medium text-gray-700 mb-1">
            Concepto <span class="text-red-500">*</span>
        </label>
        <input type="text" name="concept" id="concept" value="{{ old('concept', $income->concept ?? '') }}" required
               placeholder="Ej: Venta de productos, Servicio técnico"
               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('concept')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Monto -->
    <div>
        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
            Monto <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500">$</span>
            </div>
            <input type="number" name="amount" id="amount" step="0.01" min="0.01" 
                   value="{{ old('amount', $income->amount ?? '') }}" required
                   class="pl-8 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   placeholder="0.00">
        </div>
        @error('amount')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Fecha -->
    <div>
        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
            Fecha <span class="text-red-500">*</span>
        </label>
        <input type="date" name="date" id="date" value="{{ old('date', $income->date ?? date('Y-m-d')) }}" required
               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

  
    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
            Descripción
        </label>
        <textarea name="description" id="description" rows="3"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  placeholder="Descripción detallada del ingreso">{{ old('description', $income->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<!-- Botones -->
<div class="mt-8 flex justify-end space-x-4">
    <a href="{{ route('incomes.index') }}" 
       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
        Cancelar
    </a>
    <button type="submit" 
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
        {{ isset($income) ? 'Actualizar' : 'Guardar' }}
    </button>
</div>