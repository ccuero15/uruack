<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Relación de Contratos Labores</h2>
                    <a href="{{ route('contratos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">+ Nuevo Contrato</a>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Empleado</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Cargo</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Sueldo</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($contratos as $c)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $c->empleado->nombre }} {{ $c->empleado->apellido }}</td>
                            <td class="px-6 py-4 text-sm">{{ $c->cargo->titulo }}</td>
                            <td class="px-6 py-4 text-sm font-bold">${{ number_format($c->salario_base, 2) }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 {{ $c->estado == 'Vigente' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full text-xs font-bold">
                                    {{ $c->estado }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
