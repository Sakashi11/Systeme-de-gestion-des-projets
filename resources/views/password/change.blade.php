@extends('layouts.app')

@section('title', 'Changer le mot de passe')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">

        <div class="text-center mb-8">
            <i class="fas fa-lock text-blue-700 text-5xl"></i>
            <h1 class="text-2xl font-bold text-gray-800 mt-4">Changer le mot de passe</h1>
            <p class="text-gray-500 mt-2">Vous devez changer votre mot de passe avant de continuer</p>
        </div>

        <div class="bg-blue-50 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-info-circle mr-1"></i>
            Note : Votre code d'accès reste inchangé pour la connexion.
        </div>

        @if(session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                {{ session('warning') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/password/change">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-lock mr-1"></i>Nouveau mot de passe
                </label>
                <input
                    type="password"
                    name="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    placeholder="••••••••"
                    required
                />
            </div>

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

            <button
                type="submit"
                class="w-full bg-blue-700 text-white py-2 rounded-lg hover:bg-blue-800 font-medium transition">
                <i class="fas fa-save mr-2"></i>Enregistrer le nouveau mot de passe
            </button>
        </form>
    </div>
</div>
@endsection