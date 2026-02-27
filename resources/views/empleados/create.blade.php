<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow rounded-lg">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Nuevo Registro de Empleado</h2>
                <form action="{{ route('empleados.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cédula</label>
                            <input type="text" name="cedula" value="{{ old('cedula') }}" maxlength="20" required
                                data-type="numeric"
                                class="mt-1 block w-full rounded-md shadow-sm @error('cedula') border-red-500 @else border-gray-300 @enderror">
                            @error('cedula')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email (Opcional)</label>
                            <input type="email" name="email" value="{{ old('email') }}" maxlength="150"
                                class="mt-1 block w-full rounded-md shadow-sm @error('email') border-red-500 @else border-gray-300 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" maxlength="100" required
                                data-type="alpha"
                                class="mt-1 block w-full rounded-md shadow-sm @error('nombre') border-red-500 @else border-gray-300 @enderror">
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellido</label>
                            <input type="text" name="apellido" value="{{ old('apellido') }}" maxlength="100" required
                                data-type="alpha"
                                class="mt-1 block w-full rounded-md shadow-sm @error('apellido') border-red-500 @else border-gray-300 @enderror">
                            @error('apellido')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                            <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', date('Y-m-d')) }}"
                                required
                                class="mt-1 block w-full rounded-md shadow-sm @error('fecha_ingreso') border-red-500 @else border-gray-300 @enderror">
                            @error('fecha_ingreso')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado Inicial</label>
                            <select name="estado" required
                                class="mt-1 block w-full rounded-md shadow-sm @error('estado') border-red-500 @else border-gray-300 @enderror">
                                <option value="Activo">Activo</option>
                                <option value="Suspendido">Suspendido</option>
                            </select>
                            @error('estado')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('empleados.index') }}" class="px-4 py-2 text-gray-600">Cancelar</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Guardar
                            Empleado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
