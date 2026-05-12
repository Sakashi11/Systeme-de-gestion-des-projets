@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">

        <!-- Logo -->
        <div class="text-center mb-8">
            <i class="fas fa-project-diagram text-blue-700 text-5xl"></i>
            <h1 class="text-2xl font-bold text-gray-800 mt-4">Project Manager</h1>
            <p class="text-gray-500 mt-2">Créer un nouveau compte</p>
        </div>

        <!-- Erreurs -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="/register">
            @csrf

            <!-- Nom -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-user mr-1"></i>Nom complet
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    placeholder="John Doe"
                    required
                />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-envelope mr-1"></i>Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    placeholder="votre@email.com"
                    required
                />
            </div>

            <!-- Profession -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-briefcase mr-1"></i>Profession
                </label>
                <input
                    type="text"
                    name="profession"
                    value="{{ old('profession') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    placeholder="Développeur, Designer..."
                />
            </div>

            <!-- Mot de passe -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-lock mr-1"></i>Mot de passe
                </label>
                <input
                    type="password"
                    name="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    placeholder="••••••••"
                    required
                />
            </div>

            <!-- Confirmer mot de passe -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-lock mr-1"></i>Confirmer le mot de passe
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    placeholder="••••••••"
                    required
                />
            </div>

            <!-- Bouton -->
            <button
                type="submit"
                class="w-full bg-blue-700 text-white py-2 rounded-lg hover:bg-blue-800 font-medium transition">
                <i class="fas fa-user-plus mr-2"></i>S'inscrire
            </button>
        </form>

        <!-- Lien Login -->
        <p class="text-center text-gray-500 mt-6">
            Déjà un compte ?
            <a href="/login" class="text-blue-700 hover:underline font-medium">Se connecter</a>
        </p>

    </div>
</div>
@endsection