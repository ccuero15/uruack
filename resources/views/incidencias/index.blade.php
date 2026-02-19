<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Registro de Incidencias y Novedades</h2>
                    <a href="{{ route('incidencias.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition">
                        + Registrar Novedad
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-500 uppercase">Empleado</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-500 uppercase">Tipo</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-bold text-gray-500 uppercase">Hrs Extras</th>
                                <th class="px-6 py-3 border-b text-center text-xs font-bold text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($incidencias as $inc)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $inc->empleado->nombre }} {{ $inc->empleado->apellido }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 {{ $inc->tipoIncidencia->afecta_pago ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800' }} rounded text-xs font-bold">
                                        {{ $inc->tipoIncidencia->nombre }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($inc->fecha_inicio)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-bold">
                                    {{ $inc->horas_extras ?? 0 }}h
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('incidencias.edit', $inc) }}" class="text-blue-600 hover:text-blue-900 text-sm font-bold">Editar</a>
                                        <form id="delete-incidencia-{{ $inc->id }}" action="{{ route('incidencias.destroy', $inc) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-incidencia-{{ $inc->id }}', '¿Deseas eliminar esta incidencia?')" class="text-red-600 hover:text-red-900 text-sm font-bold">Borrar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $incidencias->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>