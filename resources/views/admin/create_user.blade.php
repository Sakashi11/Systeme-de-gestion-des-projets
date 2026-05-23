@extends('layouts.app')

@section('title', 'Créer un Utilisateur')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="/admin/users" class="text-blue-700 hover:underline mr-4">
            <i class="fas fa-arrow-left mr-1"></i>Retour
        </a>
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-user-plus mr-2 text-blue-700"></i>Créer un Utilisateur
        </h1>
    </div>

    {{-- Afficher les identifiants générés --}}
    @if(session('success') && session('generated_code'))
    <div class="bg-green-50 border border-green-400 rounded-lg p-6 mb-6">
        <h2 class="text-lg font-bold text-green-700 mb-3">
            <i class="fas fa-check-circle mr-2"></i>Utilisateur créé avec succès !
        </h2>
        <p class="text-green-700 mb-3">Communiquez ces identifiants à l'utilisateur :</p>
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
                <span class="text-gray-600 font-medium">Code d'accès :</span>
                <span class="font-bold text-red-600 text-lg tracking-widest">{{ session('generated_code') }}</span>
            </div>
        </div>
        <p class="text-sm text-green-600 mt-3">
            <i class="fas fa-info-circle mr-1"></i>
            Communiquez ces identifiants à l'utilisateur pour qu'il puisse se connecter.
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

        <form method="POST" action="/admin/users">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-user mr-1"></i>Nom
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                        placeholder="Dupont"
                        required
                    />
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-user mr-1"></i>Prénom
                    </label>
                    <input
                        type="text"
                        name="prenom"
                        value="{{ old('prenom') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                        placeholder="Jean"
                        required
                    />
                </div>
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
                    placeholder="jean.dupont@example.com"
                    required
                />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-calendar mr-1"></i>Date de naissance
                </label>
                <input
                    type="date"
                    name="date_naissance"
                    value="{{ old('date_naissance') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
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

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-shield-alt mr-1"></i>Rôle
                </label>
                <select name="role" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                    <option value="">Sélectionner un rôle</option>
                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="chef_projet" {{ old('role') == 'chef_projet' ? 'selected' : '' }}>Chef de Projet</option>
                    <option value="membre" {{ old('role') == 'membre' ? 'selected' : '' }}>Membre</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-users mr-1"></i>Équipe (optionnel)
                </label>
                <select name="team_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">Aucune équipe</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800">
                    <i class="fas fa-user-plus mr-2"></i>Créer l'utilisateur
                </button>
                <a href="/admin/users" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection