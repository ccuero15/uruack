<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Gestión de Empleados</h2>
                    @if (in_array(auth()->user()->rol_id, [1, 2]))
                        <a href="{{ route('empleados.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                            + Nuevo Empleado
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">
                                    Cédula</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">
                                    Nombre Completo</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">
                                    Estado</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $emp)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 border-b">{{ $emp->cedula }}</td>
                                    <td class="px-6 py-4 border-b">{{ $emp->nombre }} {{ $emp->apellido }}</td>
                                    <td class="px-6 py-4 border-b">
                                        <span
                                            class="px-2 py-1 rounded text-xs {{ $emp->estado == 'Activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $emp->estado }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 border-b">
                                        <div class="flex items-center space-x-3">
                                            @if (in_array(auth()->user()->rol_id, [1, 2]))
                                                <a href="{{ route('empleados.edit', $emp) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            @endif
                                            <a href="{{ route('contratos.index', ['empleado_id' => $emp->id]) }}"
                                                class="text-green-600 hover:text-green-900">Contrato</a>
                                            @if (in_array(auth()->user()->rol_id, [1, 2]) && $emp->estado == 'Activo')
                                                <form id="desactivar-empleado-{{ $emp->id }}"
                                                    action="{{ route('empleados.desactivar', $emp->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="button"
                                                        onclick="confirmDelete('desactivar-empleado-{{ $emp->id }}', '¿Deseas desactivar a este empleado?')"
                                                        class="text-red-600 hover:text-red-900 font-bold">Desactivar</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $empleados->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
