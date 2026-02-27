<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        window.confirmAction = function(options) {
            return Swal.fire({
                title: options.title || '¿Estás seguro?',
                text: options.text || 'Esta acción no se puede deshacer.',
                icon: options.icon || 'warning',
                showCancelButton: true,
                confirmButtonColor: options.confirmButtonColor || '#3085d6',
                cancelButtonColor: options.cancelButtonColor || '#d33',
                confirmButtonText: options.confirmButtonText || 'Sí, continuar',
                cancelButtonText: options.cancelButtonText || 'Cancelar'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // 1. Enforzar maxlength en todos los inputs
            document.querySelectorAll('input[maxlength]').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.length > this.maxLength) {
                        this.value = this.value.slice(0, this.maxLength);
                    }
                });
            });

            // 2. Restricción de tipo de caracteres (Solo letras o solo números)
            document.querySelectorAll('input[data-type]').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.dataset.type === 'alpha') {
                        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                    } else if (this.dataset.type === 'numeric') {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    }
                });
            });

            // 3. UX para inputs numéricos nativos
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('keydown', function(e) {
                    if (['ArrowUp', 'ArrowDown'].includes(e.key)) e.preventDefault();
                });
                input.addEventListener('wheel', e => e.preventDefault(), {
                    passive: false
                });
            });

            // 4. Bloqueo de caracteres no permitidos en campos numéricos específicos (opcional/seguridad)
            const preventInvalidChars = (e) => {
                if (['e', 'E', '+', '-'].includes(e.key) && e.target.min >= 0) {
                    e.preventDefault();
                }
            };
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('keydown', preventInvalidChars);
            });
        });
    </script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col">

        @include('layouts.navigation')
        <!-- Header -->


        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-grow">
            <!-- Alertas Globales -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 shadow-md rounded-r-lg mb-4 flex items-center"
                        role="alert">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-bold">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 shadow-md rounded-r-lg mb-4 flex items-center"
                        role="alert">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-bold">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            {{ $slot }}
        </main>

    </div>

    @stack('scripts')
</body>

</html>
