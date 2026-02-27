<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Historial de Nóminas</h2>
                    @if (auth()->user()->rol_id == 1)
                        <a href="{{ route('nomina.create') }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Nueva Ejecución
                        </a>
                    @endif
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periodo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Ejecución
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comentario</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($ejecuciones as $e)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $e->periodo_inicio }} al
                                    {{ $e->periodo_fin }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $e->fecha_ejecucion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-bold rounded
                                        {{ $e->estado == 'Procesada'
                                            ? 'bg-green-100 text-green-800'
                                            : ($e->estado == 'No Procesada'
                                                ? 'bg-red-100 text-red-800'
                                                : 'bg-yellow-100 text-yellow-800') }}">
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
                                        @if (auth()->user()->rol_id == 1 && ($e->estado == 'Borrador' || $e->estado == 'No Procesada'))
                                            <form action="{{ route('nomina.procesar', $e->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs font-bold transition">
                                                    Procesar Ahora
                                                </button>
                                            </form>
                                        @endif

                                        <div x-data="{ open: false }">
                                            @if (auth()->user()->rol_id == 1 &&
                                                    ($e->estado == 'Procesada' || $e->estado == 'Borrador' || $e->estado == 'No Procesada'))
                                                <button @click="open = true"
                                                    class="text-red-600 hover:text-red-900 font-bold ml-2">Anular</button>
                                            @endif
                                            <a href="{{ route('nomina.show', $e->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                                            <a href="{{ route('nomina.reporte.general', $e->id) }}"
                                                class="text-green-600 hover:text-green-900 font-bold">Reporte</a>
                                            <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto"
                                                style="display: none;">
                                                <div
                                                    class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                    </div>
                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                        aria-hidden="true">&#8203;</span>
                                                    <div
                                                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-5 sm:align-middle sm:max-w-lg sm:w-full">
                                                        <form action="{{ route('nomina.anular', $e->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                <div class="sm:flex sm:items-start">
                                                                    <div
                                                                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                        <svg class="h-6 w-6 text-red-600" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div
                                                                        class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                                        <h3
                                                                            class="text-lg leading-6 font-medium text-gray-900">
                                                                            Anular Nómina</h3>
                                                                        <div class="mt-2">
                                                                            <p class="text-sm text-gray-500">¿Estás
                                                                                seguro de que deseas anular esta nómina?
                                                                                Esta acción no se puede deshacer.</p>
                                                                            <textarea name="motivo" placeholder="Motivo de la anulación (mín. 10 caracteres)..."
                                                                                class="mt-4 w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" required
                                                                                minlength="10"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                <button type="submit"
                                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Anular</button>
                                                                <button @click="open = false" type="button"
                                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
