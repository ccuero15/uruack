<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reporte Consolidado de Nómina: {{ $nomina->periodo_inicio }} / {{ $nomina->periodo_fin }}
            </h2>
            <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded text-sm font-bold print:hidden">
                Imprimir Reporte
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left text-xs font-bold uppercase">Empleado</th>
                                <th class="border border-gray-300 px-4 py-2 text-left text-xs font-bold uppercase">Cargo</th>
                                <th class="border border-gray-300 px-4 py-2 text-right text-xs font-bold uppercase">Sueldo Base</th>
                                <th class="border border-gray-300 px-4 py-2 text-right text-xs font-bold uppercase text-green-600">Total Beneficios</th>
                                <th class="border border-gray-300 px-4 py-2 text-right text-xs font-bold uppercase text-red-600">Total Deducciones</th>
                                <th class="border border-gray-300 px-4 py-2 text-right text-xs font-bold uppercase bg-indigo-50">Neto a Pagar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $grandTotalBruto = 0;
                                $grandTotalBen = 0;
                                $grandTotalDed = 0;
                                $grandTotalNeto = 0;
                            @endphp

                            @foreach($nomina->items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2 text-sm">
                                    {{ $item->empleado->nombre }} {{ $item->empleado->apellido }}
                                    <div class="text-xs text-gray-400">{{ $item->empleado->cedula }}</div>
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-xs text-gray-600">
                                    {{ $item->empleado->contratos->where('estado','Vigente')->first()->cargo->titulo ?? 'N/A' }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-right text-sm">
                                    ${{ number_format($item->salario_bruto, 2) }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-right text-sm text-green-700">
                                    +${{ number_format($item->total_beneficios, 2) }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-right text-sm text-red-700">
                                    -${{ number_format($item->total_deducciones, 2) }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-right text-sm font-bold bg-indigo-50">
                                    ${{ number_format($item->salario_neto, 2) }}
                                </td>
                            </tr>
                            @php
                                $grandTotalBruto += $item->salario_bruto;
                                $grandTotalBen += $item->total_beneficios;
                                $grandTotalDed += $item->total_deducciones;
                                $grandTotalNeto += $item->salario_neto;
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-800 text-white font-bold">
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-right uppercase text-xs">Totales Generales:</td>
                                <td class="px-4 py-3 text-right">${{ number_format($grandTotalBruto, 2) }}</td>
                                <td class="px-4 py-3 text-right">${{ number_format($grandTotalBen, 2) }}</td>
                                <td class="px-4 py-3 text-right">${{ number_format($grandTotalDed, 2) }}</td>
                                <td class="px-4 py-3 text-right bg-indigo-700">${{ number_format($grandTotalNeto, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-8 text-xs text-gray-500 italic">
                    Reporte generado el: {{ now()->format('d/m/Y H:i:s') }} - Sistema de Nómina Laravel
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
