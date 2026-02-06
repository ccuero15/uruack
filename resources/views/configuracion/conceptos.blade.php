<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Configuración de Conceptos de Nómina</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-8 border-red-500">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 uppercase">Deducciones</h3>
                        <p class="text-sm text-gray-500">Egresos que se descuentan del salario bruto.</p>
                    </div>
                    <button onclick="toggleModal('modalDeduccion')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-bold transition">
                        + Nueva Deducción
                    </button>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($deducciones as $d)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $d->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $d->tasa }}{{ $d->tipo == 'Porcentaje' ? '%' : '$' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $d->tipo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <form action="{{ route('deducciones.destroy', $d) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-8 border-green-500">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 uppercase">Beneficios / Bonos</h3>
                        <p class="text-sm text-gray-500">Ingresos adicionales al salario pactado.</p>
                    </div>
                    <button onclick="toggleModal('modalBeneficio')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-bold transition">
                        + Nuevo Beneficio
                    </button>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($beneficios as $b)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $b->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $b->tasa }}{{ $b->tipo == 'Porcentaje' ? '%' : '$' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $b->tipo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <form action="{{ route('beneficios.destroy', $b) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modalDeduccion" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h3 class="text-lg font-bold mb-4">Agregar Deducción</h3>
            <form action="{{ route('deducciones.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <input type="text" name="nombre" placeholder="Nombre (ej: Seguro Social)" required class="w-full border-gray-300 rounded-md shadow-sm">
                    <input type="number" step="0.01" name="tasa" placeholder="Valor o %" required class="w-full border-gray-300 rounded-md shadow-sm">
                    <select name="tipo" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="Porcentaje">Porcentaje (%)</option>
                        <option value="Fijo">Monto Fijo ($)</option>
                    </select>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('modalDeduccion')" class="text-gray-500 px-4 py-2">Cancelar</button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalBeneficio" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h3 class="text-lg font-bold mb-4">Agregar Beneficio</h3>
            <form action="{{ route('beneficios.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <input type="text" name="nombre" placeholder="Nombre (ej: Bono Alimenticio)" required class="w-full border-gray-300 rounded-md shadow-sm">
                    <input type="number" step="0.01" name="tasa" placeholder="Valor o %" required class="w-full border-gray-300 rounded-md shadow-sm">
                    <select name="tipo" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="Porcentaje">Porcentaje (%)</option>
                        <option value="Fijo">Monto Fijo ($)</option>
                    </select>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('modalBeneficio')" class="text-gray-500 px-4 py-2">Cancelar</button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
