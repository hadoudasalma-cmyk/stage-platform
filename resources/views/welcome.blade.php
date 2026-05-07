<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StageConnect — Trouvez le stage qui vous correspond</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { primary: { 50:'#eff6ff',100:'#dbeafe',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' } }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-white text-slate-800">

<!-- Navbar -->
<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="font-bold text-lg text-slate-800">StageConnect</span>
        </div>
        <div class="flex items-center gap-3">
            @auth
                @if(auth()->user()->isStudent())
                    <a href="{{ route('student.dashboard') }}" class="bg-primary-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-primary-700 transition">Mon espace</a>
                @elseif(auth()->user()->isCompany())
                    <a href="{{ route('company.dashboard') }}" class="bg-primary-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-primary-700 transition">Mon espace</a>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="bg-primary-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-primary-700 transition">Admin</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-800 transition">Connexion</a>
                <a href="{{ route('register') }}" class="bg-primary-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-primary-700 transition">S'inscrire</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="max-w-6xl mx-auto px-4 pt-20 pb-24 text-center">
    <div class="inline-flex items-center gap-2 bg-primary-50 text-primary-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-6">
        <span class="w-1.5 h-1.5 bg-primary-500 rounded-full animate-pulse"></span>
        500+ offres disponibles au Maroc
    </div>
    <h1 class="text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
        Trouvez le stage<br>
        <span class="text-primary-600">qui vous correspond</span>
    </h1>
    <p class="text-xl text-slate-500 max-w-2xl mx-auto mb-10">
        La plateforme qui connecte les étudiants marocains avec les meilleures entreprises — candidature simple, entretiens planifiés.
    </p>
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('register') }}" class="bg-primary-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-primary-700 transition text-sm">
            Commencer gratuitement
        </a>
        <a href="{{ route('student.internships.index') }}" class="bg-white border border-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl hover:border-slate-300 transition text-sm">
            Voir les offres →
        </a>
    </div>
</section>

<!-- Features -->
<section class="bg-slate-50 py-20">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-slate-800 mb-12">Tout ce dont vous avez besoin</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="font-semibold text-slate-800 mb-2">Recherche avancée</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Filtrez par domaine, ville, type de stage ou rémunération. Trouvez l'offre idéale en quelques secondes.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-semibold text-slate-800 mb-2">Suivi en temps réel</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Suivez l'état de vos candidatures instantanément — en attente, acceptée, ou invitation à un entretien.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-semibold text-slate-800 mb-2">Entretiens planifiés</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Les entreprises planifient les entretiens directement sur la plateforme — date, heure, présentiel ou en ligne.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-slate-800 mb-4">Prêt à démarrer ?</h2>
        <p class="text-slate-500 mb-8">Rejoignez des milliers d'étudiants et d'entreprises sur StageConnect.</p>
        <a href="{{ route('register') }}" class="bg-primary-600 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-primary-700 transition">
            Créer mon compte gratuitement
        </a>
    </div>
</section>

<footer class="border-t border-slate-100 py-8 text-center text-sm text-slate-400">
    © 2026 StageConnect. Tous droits réservés.
</footer>

</body>
</html>
