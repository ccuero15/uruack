<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm rounded-lg">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Registrar Nuevo Contrato</h2>

                <form action="{{ route('contratos.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Empleado</label>
                            <select name="empleado_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($empleados as $e)
                                    <option value="{{ $e->id }}">{{ $e->cedula }} - {{ $e->nombre }} {{ $e->apellido }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cargo</label>
                            <select name="cargo_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($cargos as $c)
                                    <option value="{{ $c->id }}">{{ $c->titulo }} (${{ $c->salario_referencial }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Salario Mensual Pactado</label>
                            <input type="number" step="0.01" name="salario_pactado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jornada Laboral</label>
                            <select name="jornada_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($jornadas as $j)
                                    <option value="{{ $j->id }}">{{ $j->nombre }} ({{ $j->horas_semanales }}h)</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado del Contrato</label>
                            <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Vigente">Vigente</option>
                                <option value="Borrador">Borrador</option>
                                <option value="Suspendido">Suspendido</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('contratos.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                            Guardar Contrato
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
