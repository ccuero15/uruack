<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg mb-6">
                <h2 class="text-xl font-bold mb-4">Resumen de Nómina: {{ $ejecucion->periodo_inicio }} / {{ $ejecucion->periodo_fin }}</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="p-4 bg-gray-50 rounded">
                        <p class="text-sm text-gray-500">Total Bruto</p>
                        <p class="text-lg font-bold">${{ number_format($ejecucion->items->sum('salario_bruto'), 2) }}</p>
                    </div>
                    <div class="p-4 bg-red-50 rounded">
                        <p class="text-sm text-red-500">Total Deducciones</p>
                        <p class="text-lg font-bold text-red-700">${{ number_format($ejecucion->items->sum('total_deducciones'), 2) }}</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded">
                        <p class="text-sm text-green-500">Neto a Pagar</p>
                        <p class="text-lg font-bold text-green-700">${{ number_format($ejecucion->items->sum('salario_neto'), 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empleado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salario Bruto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deducciones</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Beneficios</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Neto</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Recibo</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($ejecucion->items as $item)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $item->empleado->nombre }} {{ $item->empleado->apellido }}</td>
                            <td class="px-6 py-4">${{ number_format($item->salario_bruto, 2) }}</td>
                            <td class="px-6 py-4 text-red-600">-${{ number_format($item->total_deducciones, 2) }}</td>
                            <td class="px-6 py-4 text-green-600">+${{ number_format($item->total_beneficios, 2) }}</td>
                            <td class="px-6 py-4 font-bold">${{ number_format($item->salario_neto, 2) }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('nomina.recibo', $item->id) }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded text-sm">PDF</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
