@extends('layouts.app')

@section('title', 'Créer un Membre')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="/chef/membres" class="text-blue-700 hover:underline mr-4">
            <i class="fas fa-arrow-left mr-1"></i>Retour
        </a>
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-user-plus mr-2 text-blue-700"></i>Créer un Membre
        </h1>
    </div>

    {{-- Afficher les identifiants générés --}}
    @if(session('success') && session('generated_password'))
    <div class="bg-green-50 border border-green-400 rounded-lg p-6 mb-6">
        <h2 class="text-lg font-bold text-green-700 mb-3">
            <i class="fas fa-check-circle mr-2"></i>Membre créé avec succès !
        </h2>
        <p class="text-green-700 mb-3">Communiquez ces identifiants au nouveau membre :</p>
        <div class="bg-white rounded-lg p-4 border border-green-200">
            <div class="flex justify-between mb-2">
                <span class="text-gray-600 font-medium">Nom :</span>
                <span class="font-bold text-gray-800">{{ session('generated_name') }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-gray-600 font-medium">Email :</span>
                <span class="font-bold text-gray-800">{{ session('generated_email') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600 font-medium">Mot de passe :</span>
                <span class="font-bold text-red-600 text-lg">{{ session('generated_password') }}</span>
            </div>
        </div>
        <p class="text-sm text-green-600 mt-3">
            <i class="fas fa-info-circle mr-1"></i>
            Le membre devra changer son mot de passe à la première connexion.
        </p>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/chef/membres">
            @csrf

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

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-envelope mr-1"></i>Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    placeholder="john@example.com"
                    required
                />
            </div>

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

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-users mr-1"></i>Équipe
                </label>
                <select name="team_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                    <option value="">Sélectionner une équipe</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800">
                    <i class="fas fa-user-plus mr-2"></i>Créer le membre
                </button>
                <a href="/chef/membres" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection