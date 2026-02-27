<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm rounded-lg border-t-4 border-indigo-600">
                <h2 class="text-2xl font-bold mb-2 text-gray-800">Procesar Nueva Nómina</h2>
                <p class="text-gray-500 mb-8">Selecciona el rango de fechas para calcular sueldos e incidencias.</p>

                <form action="{{ route('nomina.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase">Inicio del Periodo</label>
                            <input type="date" name="periodo_inicio" value="{{ old('periodo_inicio') }}" required
                                class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('periodo_inicio') border-red-500 @else border-gray-300 @enderror">
                            @error('periodo_inicio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase">Fin del Periodo</label>
                            <input type="date" name="periodo_fin" value="{{ old('periodo_fin') }}" required
                                class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('periodo_fin') border-red-500 @else border-gray-300 @enderror">
                            @error('periodo_fin')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-bold text-gray-700 uppercase">Comentario / Nota</label>
                        <textarea name="comentario" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Ej: Nómina correspondiente a la primera quincena de marzo..."></textarea>
                    </div>

                    <div class="mt-8 p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-800 text-sm">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <strong class="font-bold">¡IMPORTANTE!</strong>
                        </div>
                        <p class="mt-1">No se permiten procesar o crear nóminas con periodos que finalicen después de
                            la fecha actual por razones legales y contables.</p>
                    </div>

                    <div class="mt-4 p-4 bg-blue-50 border-l-4 border-blue-400 text-blue-700 text-sm">
                        <strong>Información:</strong> Al crear esta ejecución se guardará como borrador. Podrás procesar
                        los cálculos masivos desde el historial.
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('nomina.index') }}"
                            class="text-gray-600 px-4 py-2 hover:underline">Cancelar</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-8 py-2 rounded-md font-bold hover:bg-indigo-700 shadow-lg transition">
                            Crear Borrador de Nómina
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
