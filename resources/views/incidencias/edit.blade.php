<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow rounded-lg">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Editar Incidencia</h2>

                <form action="{{ route('incidencias.update', $incidencia) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Empleado</label>
                            <select name="empleado_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                                @foreach($empleados as $e)
                                    <option value="{{ $e->id }}" {{ $incidencia->empleado_id == $e->id ? 'selected' : '' }}>
                                        {{ $e->nombre }} {{ $e->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Incidencia</label>
                            <select name="tipo_incidencia_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                                @foreach($tipos as $t)
                                    <option value="{{ $t->id }}" {{ $incidencia->tipo_incidencia_id == $t->id ? 'selected' : '' }}>
                                        {{ $t->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" value="{{ $incidencia->fecha_inicio }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Horas Extras</label>
                            <input type="number" step="0.5" name="horas_extras" value="{{ $incidencia->horas_extras }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observacion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $incidencia->observacion }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('incidencias.index') }}" class="px-4 py-2 text-gray-600 underline text-sm">Cancelar</a>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-md font-bold hover:bg-blue-700 transition shadow-md">
                            Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
