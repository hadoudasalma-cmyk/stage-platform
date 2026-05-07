@extends('layouts.guest')
@section('title', 'Connexion — StageConnect')

@section('content')
<div>
    <h2 class="text-2xl font-bold text-gray-800 mb-1">Bon retour 👋</h2>
    <p class="text-gray-500 mb-8">Connectez-vous à votre compte</p>

    <!-- Validation errors -->
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                placeholder="vous@exemple.com">
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:underline">Mot de passe oublié ?</a>
                @endif
            </div>
            <input type="password" name="password" required
                class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('password') ? 'border-red-400' : 'border-gray-300' }}"
                placeholder="••••••••">
        </div>

        <!-- Remember me -->
        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-blue-600">
            <label for="remember" class="text-sm text-gray-600">Se souvenir de moi</label>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors duration-150 text-sm mt-2">
            Se connecter
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">S'inscrire</a>
    </p>
</div>
@endsection
