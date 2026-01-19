<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Nómina: {{ $nomination->period }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <!-- Información general de la nómina -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Estado actual:</p>
                            <span class="inline-flex px-4 py-1.5 mt-1 text-base font-semibold rounded-full
                                {{ $nomination->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : '' }}
                                {{ $nomination->status === 'pending'  ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : '' }}
                                {{ $nomination->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' : '' }}
                                {{ $nomination->status === 'paid'     ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' : '' }}">
                                {{ ucfirst($nomination->status) }}
                            </span>
                        </div>

                        @if($nomination->status === 'pending')
                            <form action="{{ route('nominations.process', $nomination) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                                    Procesar Nómina
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Mensaje cuando está pendiente y aún no procesada -->
                    @if($nomination->status === 'pending')
                        <div class="bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-400 dark:border-yellow-600 p-5 mb-8 rounded-r-lg">
                            <p class="text-yellow-700 dark:text-yellow-300 text-base">
                                Esta nómina aún no ha sido procesada.
                                Haz clic en el botón <strong>"Procesar Nómina"</strong> para generar el cálculo preliminar.
                            </p>
                        </div>
                    @endif

                    <!-- Sección de detalles (solo si está aprobada) -->
                    @if($nomination->status === 'approved')
                        @if($nomination->details?->isNotEmpty())
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                                Detalles procesados y guardados
                            </h3>

                            <div class="space-y-10">
                                @foreach($nomination->details->groupBy('employee_id') as $employee_id => $detailsGroup)
                                    @php
                                        $employee = App\Models\Employee::find($employee_id);
                                        if (!$employee) continue;
                                    @endphp

                                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm">
                                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-5">
                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                                                <div>
                                                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $employee->name }} {{ $employee->last_name ?? '' }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                        C.I.: {{ $employee->dni ?? 'No registrada' }}
                                                        • Cargo: {{ $employee->position?->name ?? 'Sin cargo' }}
                                                    </p>
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    Sueldo base: ${{ number_format($employee->base_salary, 2) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                <thead class="bg-gray-100 dark:bg-gray-600">
                                                    <tr>
                                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                            Concepto
                                                        </th>
                                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                            Tipo
                                                        </th>
                                                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                            Monto
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                    @foreach($detailsGroup as $detail)
                                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                                {{ $detail->concept->name ?? '—' }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                                {{ $detail->concept->type === 'assignment' ? 'Asignación' : 'Deducción' }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium
                                                                {{ $detail->amount >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                                ${{ number_format($detail->amount, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-400 dark:border-yellow-600 p-5 rounded-r-lg">
                                <p class="text-yellow-700 dark:text-yellow-300 text-base">
                                    La nómina fue aprobada, pero no se encontraron detalles guardados.
                                </p>
                            </div>
                        @endif
                    @endif

                    <!-- Sección de incidencias -->
                    @if($nomination->incidents?->isNotEmpty())
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mt-12 mb-6">
                            Incidencias / Observaciones registradas
                        </h3>

                        <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-400 dark:border-red-600 p-5 rounded-r-lg">
                            <ul class="list-disc pl-6 space-y-3 text-red-800 dark:text-red-200">
                                @foreach($nomination->incidents as $incident)
                                    <li>
                                        <strong>Empleado ID {{ $incident->employee_id }}:</strong>
                                        {{ $incident->description }}
                                        @if($incident->employee)
                                            <span class="text-sm opacity-80 ml-2">
                                                ({{ $incident->employee->name ?? '' }} {{ $incident->employee->last_name ?? '' }})
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
