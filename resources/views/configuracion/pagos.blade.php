<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white p-6 shadow rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-red-600 uppercase tracking-wider">Deducciones (Egresos)</h3>
                    <button onclick="openModal('modalDeduccion')" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-sm">
                        + Nueva Deducción
                    </button>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tasa/Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($deducciones as $d)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $d->nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $d->tasa }}{{ $d->tipo == 'Porcentaje' ? '%' : '$' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $d->tipo }}</td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <form action="{{ route('deducciones.destroy', $d) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900 ml-2">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-6 shadow rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-green-600 uppercase tracking-wider">Beneficios (Ingresos)</h3>
                    <button onclick="openModal('modalBeneficio')" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm">
                        + Nuevo Beneficio
                    </button>
                </div>
                </div>

        </div>
    </div>

    <div id="modalDeduccion" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Nueva Deducción</h3>
            <form action="{{ route('deducciones.store') }}" method="POST">
                @csrf
                <input type="text" name="nombre" placeholder="Ej: Seguro Social" class="w-full mb-3 rounded-md border-gray-300">
                <input type="number" step="0.01" name="tasa" placeholder="Tasa" class="w-full mb-3 rounded-md border-gray-300">
                <select name="tipo" class="w-full mb-4 rounded-md border-gray-300">
                    <option value="Porcentaje">Porcentaje</option>
                    <option value="Fijo">Valor Fijo</option>
                </select>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modalDeduccion')" class="bg-gray-200 px-4 py-2 rounded">Cerrar</button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    </script>
</x-app-layout>
