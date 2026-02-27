<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Cargos y Departamentos</h2>
                    @if (in_array(auth()->user()->rol_id, [1, 2]))
                        <a href="{{ route('cargos.create') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                            + Nuevo Cargo
                        </a>
                    @endif
                </div>

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">
                                    Título del Cargo</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">
                                    Departamento</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">
                                    Salario Ref.</th>
                                <th
                                    class="px-6 py-3 border-b text-center text-xs font-semibold text-gray-600 uppercase">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cargos as $cargo)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 border-b text-sm text-gray-800 font-medium">
                                        {{ $cargo->titulo }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-600">
                                        {{ $cargo->departamento ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-600">
                                        ${{ number_format($cargo->salario_referencial, 2) }}</td>
                                    <td class="px-6 py-4 border-b text-center text-sm">
                                        <div class="flex justify-center gap-3">
                                            @if (in_array(auth()->user()->rol_id, [1, 2]))
                                                <a href="{{ route('cargos.edit', $cargo) }}"
                                                    class="text-blue-600 hover:text-blue-900">Editar</a>
                                                <form id="delete-cargo-{{ $cargo->id }}"
                                                    action="{{ route('cargos.destroy', $cargo) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDelete('delete-cargo-{{ $cargo->id }}', '¿Deseas eliminar este cargo?')"
                                                        class="text-red-600 hover:text-red-900">Eliminar</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $cargos->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
