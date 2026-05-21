<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="text-gray-900 antialiased" style="font-family: 'Poppins', sans-serif;">
        <div class="min-h-screen flex flex-col justify-center items-center bg-brand-cream">
            
            <div class="mb-4">
                <img 
                    src="{{ asset('images/INNerpeaceLogoLogin.png') }}" 
                    class="w-80 h-auto mx-auto"
                >
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-[#F7F1E5] shadow-[0_8px_30px_rgba(74,55,40,0.12)] rounded-3xl border border-[#E8DDCC]">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
