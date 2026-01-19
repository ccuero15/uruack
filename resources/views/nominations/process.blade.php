<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Procesamiento Preliminar - {{ $nomination->period }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Resumen Preliminar de Cálculos</h3>

                    @if(count($incidents) > 0)
                        <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-400 dark:border-red-600 p-4 mb-8">
                            <p class="text-red-700 dark:text-red-300 font-medium mb-2">
                                Se detectaron incidencias ({{ count($incidents) }}):
                            </p>
                            <ul class="list-disc pl-5 space-y-1 text-red-700 dark:text-red-300">
                                @foreach($incidents as $incident)
                                    <li>
                                        <strong>{{ $incident['employee']->name }} {{ $incident['employee']->last_name ?? '' }}</strong>
                                        (Cédula: {{ $incident['employee']->dni ?? 'N/A' }}):
                                        {{ $incident['description'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-10">
                        @foreach($preliminary as $employeeId => $data)
                            @php
                                $employee = $data['employee'];
                                $netPay = $data['net_pay'];
                                $hasError = $netPay < 0;
                            @endphp

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden {{ $hasError ? 'ring-2 ring-red-500' : '' }}">
                                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $employee->name }} {{ $employee->last_name ?? '' }}
                                            </h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Cédula: {{ $employee->dni ?? 'N/A' }} • Cargo: {{ $employee->position?->name ?? 'Sin cargo' }}
                                            </p>
                                        </div>
                                        <div class="mt-3 sm:mt-0">
                                            <span class="text-lg font-bold {{ $netPay >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                Neto a pagar: ${{ number_format($netPay, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-100 dark:bg-gray-600">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Concepto</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($data['details'] as $detail)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $detail['concept']->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $detail['concept']->type === 'assignment' ? 'Asignación' : 'Deducción' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium {{ $detail['amount'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                        ${{ number_format($detail['amount'], 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10 flex flex-col sm:flex-row sm:justify-end gap-4">
                        <form action="{{ route('nominations.approve', $nomination) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="inline-flex justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                Aprobar y Guardar
                            </button>
                        </form>

                        <form action="{{ route('nominations.reject', $nomination) }}" method="POST">
                            @csrf
                            <!-- Puedes agregar campos ocultos para incidencias si quieres personalizarlas -->
                            @foreach($incidents as $incident)
                                <input type="hidden" name="incidents[{{ $incident['employee']->id }}]" value="{{ $incident['description'] }}">
                            @endforeach
                            <button type="submit"
                                    class="inline-flex justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                Rechazar y Corregir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
