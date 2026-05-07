<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StageConnect')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: { 50:'#eff6ff',100:'#dbeafe',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex">

    <!-- Panneau gauche décoratif -->
    <div class="hidden lg:flex lg:w-1/2 bg-primary-700 flex-col justify-between p-12 relative overflow-hidden">

        <!-- Motif géométrique -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -translate-y-48 translate-x-48"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full translate-y-32 -translate-x-32"></div>
        </div>

        <!-- Logo -->
        <div class="flex items-center gap-3 relative">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-white font-bold text-xl">StageConnect</span>
        </div>

        <!-- Texte central -->
        <div class="relative">
            <h1 class="text-4xl font-bold text-white leading-tight mb-4">
                Trouvez le stage<br>qui vous correspond
            </h1>
            <p class="text-primary-200 text-lg leading-relaxed">
                La plateforme qui connecte les étudiants ambitieux avec les entreprises qui recrutent.
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6 mt-10">
                <div>
                    <p class="text-3xl font-bold text-white">500+</p>
                    <p class="text-primary-300 text-sm mt-1">Offres actives</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-white">200+</p>
                    <p class="text-primary-300 text-sm mt-1">Entreprises</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-white">1k+</p>
                    <p class="text-primary-300 text-sm mt-1">Étudiants</p>
                </div>
            </div>
        </div>

        <p class="text-primary-400 text-sm relative">© 2026 StageConnect. Tous droits réservés.</p>
    </div>

    <!-- Panneau droit : formulaire -->
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="w-full max-w-md">

            <!-- Logo mobile -->
            <div class="flex items-center gap-2 mb-8 lg:hidden">
                <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-bold text-slate-800 text-lg">StageConnect</span>
            </div>

            @yield('content')
        </div>
    </div>

</body>
</html>
