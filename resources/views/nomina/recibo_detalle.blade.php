<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto bg-white p-10 shadow-lg border-t-8 border-indigo-600">

            <div class="flex justify-between items-start border-b pb-8 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 uppercase tracking-tighter">Recibo de Pago</h1>
                    <p class="text-gray-500 mt-1">Comprobante oficial de nómina</p>
                    <div class="mt-4 text-sm text-gray-600">
                        <p class="font-bold text-gray-800">EMPRESA S.A.</p>
                        <p>Rif: J-12345678-9</p>
                        <p>Dirección: Av. Principal, Edificio Central.</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 uppercase font-bold">Periodo de Pago</p>
                        <p class="text-sm font-bold text-indigo-700">
                            {{ \Carbon\Carbon::parse($item->ejecucion->periodo_inicio)->format('d/m/Y') }} -
                            {{ \Carbon\Carbon::parse($item->ejecucion->periodo_fin)->format('d/m/Y') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-2 uppercase font-bold">Fecha de Emisión</p>
                        <p class="text-sm">{{ now()->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-10 bg-gray-50 p-6 rounded-md border border-gray-200">
                <div>
                    <p class="text-xs text-gray-500 uppercase">Empleado</p>
                    <p class="font-bold text-lg text-gray-800">{{ $item->empleado->nombre }} {{ $item->empleado->apellido }}</p>
                    <p class="text-sm text-gray-600">C.I: {{ $item->empleado->cedula }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 uppercase">Cargo / Departamento</p>
                    <p class="font-bold text-gray-800">{{ $item->empleado->contratos->where('estado','Vigente')->first()->cargo->titulo ?? 'N/A' }}</p>
                    @php
                    $contratoVigente = $item->empleado->contratos->where('estado','Vigente')->first();
                    @endphp
                    @if ($contratoVigente && $contratoVigente->cargo && $contratoVigente->cargo->departamento)
                    <p class="text-sm text-gray-600 uppercase">{{ $contratoVigente->cargo->departamento }}</p>
                    @else
                    <p class="text-sm text-gray-600 uppercase">General</p>
                    @endif
                </div>
            </div>

            <div class="mb-10">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-300">
                            <th class="py-3 px-2 text-xs font-bold uppercase text-gray-600">Concepto</th>
                            <th class="py-3 px-2 text-xs font-bold uppercase text-gray-600 text-right">Asignaciones</th>
                            <th class="py-3 px-2 text-xs font-bold uppercase text-gray-600 text-right">Deducciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="py-3 px-2 text-sm text-gray-800 font-medium">Salario Base</td>
                            <td class="py-3 px-2 text-sm text-gray-800 text-right font-medium">${{ number_format($item->salario_bruto, 2) }}</td>
                            <td class="py-3 px-2 text-sm text-gray-800 text-right">-</td>
                        </tr>
                        @foreach($item->detallesBeneficios as $detalle)
                        <tr>
                            <td class="py-3 px-2 text-sm text-gray-600">{{ $detalle->beneficio->nombre }}</td>
                            <td class="py-3 px-2 text-sm text-green-600 text-right font-medium">+${{ number_format($detalle->monto, 2) }}</td>
                            <td class="py-3 px-2 text-sm text-gray-800 text-right">-</td>
                        </tr>
                        @endforeach
                        @foreach($item->detallesDeducciones as $detalle)
                        <tr>
                            <td class="py-3 px-2 text-sm text-gray-600">{{ $detalle->deduccion->nombre }}</td>
                            <td class="py-3 px-2 text-sm text-gray-800 text-right">-</td>
                            <td class="py-3 px-2 text-sm text-red-600 text-right font-medium">-${{ number_format($detalle->monto, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-gray-300">
                        <tr>
                            <td class="py-4 px-2 text-sm font-bold text-gray-800 uppercase">Subtotales</td>
                            <td class="py-4 px-2 text-sm font-bold text-green-600 text-right">${{ number_format($item->salario_bruto + $item->total_beneficios, 2) }}</td>
                            <td class="py-4 px-2 text-sm font-bold text-red-600 text-right">${{ number_format($item->total_deducciones, 2) }}</td>
                        </tr>
                        <tr class="bg-indigo-600 text-white">
                            <td class="py-4 px-4 text-lg font-bold uppercase">Neto a Cobrar</td>
                            <td></td>
                            <td class="py-4 px-4 text-2xl font-bold text-right">${{ number_format($item->salario_neto, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-20">
                <div class="flex justify-around">
                    <div class="text-center w-1/3 border-t border-gray-400 pt-4">
                        <p class="text-xs font-bold text-gray-600 uppercase">Firma del Empleador</p>
                    </div>
                    <div class="text-center w-1/3 border-t border-gray-400 pt-4">
                        <p class="text-xs font-bold text-gray-600 uppercase">Firma del Empleado</p>
                    </div>
                </div>
            </div>

            <div class="mt-20 text-center text-[10px] text-gray-400 uppercase tracking-widest">
                Este recibo es un comprobante digital generado por el sistema URUACK.
            </div>

        </div>
    </div>
</body>