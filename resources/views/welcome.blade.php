<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-white text-gray-900">

    {{-- NAV --}}
    <header class="w-full border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-end gap-4 text-sm">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-4 py-2 border rounded">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2">
                    Log in
                </a>

               {{--  @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-4 py-2 border rounded">
                        Register
                    </a>
                @endif --}}
                
            @endauth
        </div>
    </header>

    {{-- HERO --}}
    <section class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                Innovación y <br>
                Soluciones a tu Alcance
            </h1>

            <p class="text-gray-600 mb-6">
                CONSORCIO URUAK CA ofrece servicios integrales para potenciar tu negocio,
                desde consultoría estratégica hasta implementación tecnológica de vanguardia.
            </p>

            <a href="#"
                class="inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                Descubre Más
            </a>
        </div>

        <div>
            <img src="{{ asset('images/logo_empresa.jpeg') }}" alt="Imagen corporativa"
                class="rounded-lg shadow-lg w-full">
        </div>
    </section>

    {{-- SERVICIOS --}}
    <section class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">
                Nuestros Servicios Clave
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-semibold mb-2">Consultoría Estratégica</h3>
                    <p class="text-gray-600 text-sm">
                        Diseñamos planes personalizados alineados a tus objetivos.
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-semibold mb-2">Desarrollo Tecnológico</h3>
                    <p class="text-gray-600 text-sm">
                        Creamos soluciones de software robustas y escalables.
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-semibold mb-2">Seguridad y Soporte</h3>
                    <p class="text-gray-600 text-sm">
                        Protección de datos con soporte técnico continuo.
                    </p>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.footer')
</body>


</html>
