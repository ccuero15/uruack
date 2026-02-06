<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resumen del Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase">Empleados Activos</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_empleados'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase">Gasto Neto Mes Actual</p>
                    <p class="text-3xl font-bold text-green-600">${{ number_format($stats['gasto_total_mes'], 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase">Última Nómina</p>
                    <p class="text-lg font-bold text-gray-800">
                        {{ $stats['ultima_nomina'] ? $stats['ultima_nomina']->periodo_fin : 'N/A' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white shadow-sm rounded-xl p-6 border border-red-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Contratos por Vencer (30 días)
                    </h3>
                    <ul class="divide-y">
                        @forelse($stats['proximos_vencimientos'] as $contrato)
                            <li class="py-3 flex justify-between">
                                <span class="text-gray-700">{{ $contrato->nombre }} {{ $contrato->apellido }}</span>
                                <span class="font-mono text-red-600 font-bold">{{ \Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') }}</span>
                            </li>
                        @empty
                            <p class="text-gray-500 text-sm italic">No hay contratos próximos a vencer.</p>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white shadow-sm rounded-xl p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Acciones Frecuentes</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('nomina.create') }}" class="flex flex-col items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                            <span class="text-indigo-700 font-bold text-sm">Procesar Nómina</span>
                        </a>
                        <a href="{{ route('empleados.create') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <span class="text-green-700 font-bold text-sm">Nuevo Empleado</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
