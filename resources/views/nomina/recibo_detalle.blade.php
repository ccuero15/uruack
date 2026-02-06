<x-app-layout>
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
                    <p class="text-sm text-gray-600 uppercase">{{ $item->empleado->contratos->where('estado','Vigente')->first()->cargo->departamento ?? 'General' }}</p>
                </div>
            </div>

            <div class="mb-10">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-300">
                            <th class="py-3 px-2
