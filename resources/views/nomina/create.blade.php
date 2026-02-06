<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm rounded-lg border-t-4 border-indigo-600">
                <h2 class="text-2xl font-bold mb-2 text-gray-800">Procesar Nueva Nómina</h2>
                <p class="text-gray-500 mb-8">Selecciona el rango de fechas para calcular sueldos e incidencias.</p>

                <form action="{{ route('nomina.procesar') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase">Inicio del Periodo</label>
                            <input type="date" name="periodo_inicio" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase">Fin del Periodo</label>
                            <input type="date" name="periodo_fin" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-blue-50 border-l-4 border-blue-400 text-blue-700 text-sm">
                        <strong>Nota:</strong> Este proceso incluirá a todos los empleados con contratos vigentes y calculará automáticamente sus deducciones, beneficios e incidencias registradas en este rango de fechas.
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('nomina.index') }}" class="text-gray-600 px-4 py-2 hover:underline">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-2 rounded-md font-bold hover:bg-indigo-700 shadow-lg transition">
                            Ejecutar Procesamiento Masivo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
