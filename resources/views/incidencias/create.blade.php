<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow rounded-lg">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Registrar Incidencia / Novedad</h2>

                <form action="{{ route('incidencias.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Empleado</label>
                            <select name="empleado_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                                @foreach($empleados as $e)
                                    <option value="{{ $e->id }}">{{ $e->nombre }} {{ $e->apellido }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Incidencia</label>
                            <select name="tipo_incidencia_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                                @foreach($tipos as $t)
                                    <option value="{{ $t->id }}">{{ $t->nombre }} ({{ $t->afecta_pago ? 'Afecta Pago' : 'Informativa' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Horas Extras (si aplica)</label>
                            <input type="number" step="0.5" name="horas_extras" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="0.00">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observacion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('incidencias.index') }}" class="px-4 py-2 text-gray-600 underline">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                            Guardar Incidencia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
