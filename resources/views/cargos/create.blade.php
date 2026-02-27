<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm rounded-lg">
                <h2 class="text-xl font-bold mb-6 text-gray-800">{{ isset($cargo) ? 'Editar' : 'Nuevo' }} Cargo</h2>

                <form action="{{ isset($cargo) ? route('cargos.update', $cargo) : route('cargos.store') }}"
                    method="POST">
                    @csrf
                    @if (isset($cargo))
                        @method('PUT')
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título del Cargo</label>
                            <input type="text" name="titulo" value="{{ old('titulo', $cargo->titulo ?? '') }}"
                                required maxlength="100"
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('titulo') border-red-500 @else border-gray-300 @enderror">
                            @error('titulo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Departamento</label>
                            <input type="text" name="departamento"
                                value="{{ old('departamento', $cargo->departamento ?? '') }}" maxlength="100"
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('departamento') border-red-500 @else border-gray-300 @enderror">
                            @error('departamento')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Salario Referencial</label>
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                                <input type="number" step="0.01" name="salario_referencial"
                                    value="{{ old('salario_referencial', $cargo->salario_referencial ?? '') }}"
                                    min="0" max="9999999999.99" maxlength="13"
                                    class="pl-7 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('salario_referencial') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('salario_referencial')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('cargos.index') }}"
                            class="text-gray-600 px-4 py-2 hover:underline">Cancelar</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                            {{ isset($cargo) ? 'Actualizar' : 'Guardar' }} Cargo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
