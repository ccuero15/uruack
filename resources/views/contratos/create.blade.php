<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asignar Contrato') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-sm">
                    <p class="font-bold">Se encontraron errores:</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-8 shadow rounded-lg border-t-4 border-indigo-600">
                <form action="{{ route('contratos.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Seleccionar
                                Empleado</label>
                            <select name="empleado_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                                <option value="">-- Elija un empleado --</option>
                                @foreach ($empleados as $e)
                                    <option value="{{ $e->id }}"
                                        {{ old('empleado_id') == $e->id ? 'selected' : '' }}>
                                        {{ $e->cedula }} - {{ $e->nombre }} {{ $e->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Cargo /
                                Puesto</label>
                            <select name="cargo_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                                <option value="">-- Elija un cargo --</option>
                                @foreach ($cargos as $c)
                                    <option value="{{ $c->id }}"
                                        {{ old('cargo_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->titulo }} ({{ $c->departamento }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Jornada
                                Laboral</label>
                            <select name="jornada_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                                <option value="">-- Seleccione una jornada --</option>
                                @foreach ($jornadas as $j)
                                    <option value="{{ $j->id }}"
                                        {{ old('jornada_id') == $j->id ? 'selected' : '' }}>
                                        {{ $j->nombre }} ({{ $j->horas_diarias }}h diarias)
                                    </option>
                                @endforeach
                            </select>
                            @error('jornada_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Salario Base
                                Mensual ($)</label>
                            <input type="number" step="0.01" name="salario_base" value="{{ old('salario_base') }}"
                                placeholder="0.00"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                            <span class="text-xs text-gray-400 italic">Monto sobre el cual se calcularán las
                                deducciones.</span>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Tipo de
                                Contrato</label>
                            <select name="tipo_contrato" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="Tiempo Indeterminado"
                                    {{ old('tipo_contrato') == 'Tiempo Indeterminado' ? 'selected' : '' }}>Tiempo
                                    Indeterminado (Fijo)</option>
                                <option value="Tiempo Determinado"
                                    {{ old('tipo_contrato') == 'Tiempo Determinado' ? 'selected' : '' }}>Tiempo
                                    Determinado</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Fecha de
                                Inicio</label>
                            <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Estado del
                                Contrato</label>
                            <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="Vigente" {{ old('estado') == 'Vigente' ? 'selected' : '' }}>Vigente
                                </option>
                                <option value="Finalizado" {{ old('estado') == 'Finalizado' ? 'selected' : '' }}>
                                    Finalizado</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-4">
                        <a href="{{ route('contratos.index') }}"
                            class="px-6 py-2 text-gray-500 font-bold hover:text-gray-700 transition">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-10 py-2 rounded-md font-bold hover:bg-indigo-700 shadow-lg transform active:scale-95 transition">
                            Guardar Contrato
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
