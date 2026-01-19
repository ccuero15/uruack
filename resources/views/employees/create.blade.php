<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">
            Crear Empleado
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('employees.store') }}" method="POST" class="space-y-6 max-w-2xl">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 ">Nombre</label>
                                <input type="text" name="name" required
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:text-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <!-- Apellido -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 ">Apellido</label>
                                <input type="text" name="last_name" required
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:text-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Cédula -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">Cédula de identidad</label>
                            <input type="number" name="dni" id="dni" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:text-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   step="1" placeholder="Máximo 8 dígitos"
                                   onkeydown="return event.key !== 'e' && event.key !== 'E' && event.key !== '.' && event.key !== ',';">
                        </div>

                        <!-- Cargo (Position) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">Cargo</label>
                            <select name="position" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:text-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Seleccione un cargo</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ ucwords($position->name) }}</option>
                                @endforeach
                            </select>
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Salario Base -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">Salario Base</label>
                            <input type="number" name="base_salary" step="0.01" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:text-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Estatus -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">Estatus</label>
                            <select name="active" class="mt-1 block w-full rounded-md border-gray-300 dark:text-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                Guardar Empleado
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('dni');
        const MAX = 8;

        input.addEventListener('input', function () {
            let value = this.value.replace(/\D+/g, ''); // Solo números
            if (value.length > MAX) {
                value = value.slice(0, MAX);
            }
            this.value = value;
        });
    });
</script>
