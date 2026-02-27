<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Auditoría de Historial Laboral') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-sm">

            <div class="bg-white p-6 shadow-sm rounded-lg mb-6 flex flex-wrap items-end gap-4 overflow-x-auto">
                <form action="{{ route('auditoria.index') }}" method="GET" class="flex gap-4 items-end">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Filtrar por Empleado</label>
                        <select name="empleado_id"
                            class="mt-1 block w-64 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                            <option value="">-- Todos los empleados --</option>
                            @foreach ($empleados as $e)
                                <option value="{{ $e->id }}"
                                    {{ request('empleado_id') == $e->id ? 'selected' : '' }}>
                                    {{ $e->cedula }} - {{ $e->nombre }} {{ $e->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 font-bold transition">Filtrar</button>
                    @if (request()->filled('empleado_id'))
                        <a href="{{ route('auditoria.index') }}" class="text-gray-500 py-2 hover:underline">Limpiar</a>
                    @endif
                </form>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 uppercase tracking-wider text-[10px] font-bold text-gray-500">
                        <tr>
                            <th class="px-6 py-4 text-left">Empleado</th>
                            <th class="px-6 py-4 text-left">Cargo</th>
                            <th class="px-6 py-4 text-left text-center">Fecha Inicio</th>
                            <th class="px-6 py-4 text-left text-center">Fecha Fin</th>
                            <th class="px-6 py-4 text-left text-right">Salario Base</th>
                            <th class="px-6 py-4 text-left text-center">Estado</th>
                            <th class="px-6 py-4 text-left text-center">Registro</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                        @foreach ($contratos as $contrato)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">{{ $contrato->empleado->nombre }}
                                        {{ $contrato->empleado->apellido }}</div>
                                    <div class="text-xs text-gray-500 tracking-tighter">
                                        {{ $contrato->empleado->cedula }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap uppercase tracking-tight font-medium">
                                    {{ $contrato->cargo->titulo ?? 'N/A' }}
                                    <div class="text-[10px] text-gray-400 font-normal italic">
                                        {{ $contrato->cargo->departamento ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    {{ \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    {{ $contrato->fecha_fin ? \Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-indigo-600">
                                    ${{ number_format($contrato->salario_base, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $contrato->estado == 'Vigente' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $contrato->estado }}
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-center text-xs text-gray-400 italic font-mono">
                                    {{ $contrato->created_at->format('d/m/y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-6">
                    {{ $contratos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
