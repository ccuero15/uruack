<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow rounded-lg">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Editar Empleado: {{ $empleado->nombre }}</h2>
                <form action="{{ route('empleados.update', $empleado) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cédula</label>
                            <input type="text" name="cedula" value="{{ old('cedula', $empleado->cedula) }}"
                                maxlength="20" required data-type="numeric"
                                class="mt-1 block w-full rounded-md shadow-sm @error('cedula') border-red-500 @else border-gray-300 @enderror">
                            @error('cedula')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $empleado->nombre) }}"
                                maxlength="100" required data-type="alpha"
                                class="mt-1 block w-full rounded-md shadow-sm @error('nombre') border-red-500 @else border-gray-300 @enderror">
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellido</label>
                            <input type="text" name="apellido" value="{{ old('apellido', $empleado->apellido) }}"
                                maxlength="100" required data-type="alpha"
                                class="mt-1 block w-full rounded-md shadow-sm @error('apellido') border-red-500 @else border-gray-300 @enderror">
                            @error('apellido')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email (Opcional)</label>
                            <input type="email" name="email" value="{{ old('email', $empleado->email) }}"
                                maxlength="150"
                                class="mt-1 block w-full rounded-md shadow-sm @error('email') border-red-500 @else border-gray-300 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                            <input type="date" name="fecha_ingreso"
                                value="{{ old('fecha_ingreso', $empleado->fecha_ingreso) }}" required
                                class="mt-1 block w-full rounded-md shadow-sm @error('fecha_ingreso') border-red-500 @else border-gray-300 @enderror">
                            @error('fecha_ingreso')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                            <select name="estado" required
                                class="mt-1 block w-full rounded-md shadow-sm @error('estado') border-red-500 @else border-gray-300 @enderror">
                                <option value="Activo"
                                    {{ old('estado', $empleado->estado) == 'Activo' ? 'selected' : '' }}>Activo
                                </option>
                                <option value="Suspendido"
                                    {{ old('estado', $empleado->estado) == 'Suspendido' ? 'selected' : '' }}>Suspendido
                                </option>
                                <option value="Inactivo"
                                    {{ old('estado', $empleado->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo
                                </option>
                            </select>
                            @error('estado')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($contratoVigente)
                            <div class="md:col-span-2 border-t pt-4 mt-2">
                                <h3 class="text-lg font-semibold text-indigo-600 mb-4 tracking-tight">Información de
                                    Contrato Vigente</h3>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cargo Actual</label>
                                <select name="cargo_id"
                                    class="mt-1 block w-full rounded-md shadow-sm @error('cargo_id') border-red-500 @else border-gray-300 @enderror">
                                    @foreach ($cargos as $cargo)
                                        <option value="{{ $cargo->id }}"
                                            {{ old('cargo_id', $contratoVigente->cargo_id) == $cargo->id ? 'selected' : '' }}>
                                            {{ $cargo->titulo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cargo_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Salario Base ($)</label>
                                <input type="number" step="0.01" name="salario_base"
                                    value="{{ old('salario_base', $contratoVigente->salario_base) }}"
                                    class="mt-1 block w-full rounded-md shadow-sm @error('salario_base') border-red-500 @else border-gray-300 @enderror">
                                @error('salario_base')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            <div
                                class="md:col-span-2 p-4 bg-gray-50 rounded-md border border-dashed border-gray-300 text-center">
                                <p class="text-gray-500 text-sm italic">Este empleado no tiene un contrato vigente. <a
                                        href="{{ route('contratos.create', ['empleado_id' => $empleado->id]) }}"
                                        class="text-indigo-600 font-bold hover:underline">Crear contrato ahora</a></p>
                            </div>
                        @endif
                    </div>
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Actualizar
                            Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
