<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIP-RUTAN') }} - Masuk</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi Gerakan Lambat untuk Background */
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Background Pattern Halus */
        .bg-grid-pattern {
            background-image: linear-gradient(to right, #334155 1px, transparent 1px),
                linear-gradient(to bottom, #334155 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: linear-gradient(to bottom, transparent, 10% black, 90% black, transparent);
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-900 bg-slate-900 overflow-hidden relative selection:bg-blue-500 selection:text-white">

    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.05] pointer-events-none"></div>

        <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
        <div class="w-full sm:max-w-md px-8 py-10 bg-white/95 backdrop-blur-xl shadow-[0_20px_50px_rgba(8,_112,_184,_0.2)] sm:rounded-3xl border border-white/20 transform transition-all hover:scale-[1.005] duration-500">
            {{ $slot }}
        </div>

        <div class="mt-8 text-slate-400 text-sm font-medium tracking-wide">
            &copy; {{ date('Y') }} Sistem Informasi Kunjungan Tahanan
        </div>
    </div>
</body>

</html>