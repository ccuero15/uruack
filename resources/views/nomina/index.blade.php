<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Historial de Nóminas</h2>
                    <a href="{{ route('nomina.create') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Nueva Ejecución
                    </a>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periodo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Ejecución</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comentario</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($ejecuciones as $e)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $e->periodo_inicio }} al {{ $e->periodo_fin }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $e->fecha_ejecucion }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-bold rounded 
                                        {{ $e->estado == 'Procesada' ? 'bg-green-100 text-green-800' : 
                                           ($e->estado == 'No Procesada' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $e->estado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 italic">
                                    {{ $e->comentario ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900">
                                    ${{ number_format($e->total_pagado, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center space-x-3">
                                        @if($e->estado == 'Borrador' || $e->estado == 'No Procesada')
                                            <form action="{{ route('nomina.procesar', $e->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs font-bold transition">
                                                    Procesar Ahora
                                                </button>
                                            </form>
                                        @endif

                                        @if($e->estado == 'Procesada')
                                            <a href="{{ route('nomina.show', $e->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                                            <a href="{{ route('nomina.reporte.general', $e->id) }}" class="text-green-600 hover:text-green-900 font-bold">Reporte</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
