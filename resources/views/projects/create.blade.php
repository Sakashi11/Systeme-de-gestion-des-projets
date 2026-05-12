@extends('layouts.app')

@section('title', 'Créer un Projet')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="/projects" class="text-blue-700 hover:underline mr-4">
            <i class="fas fa-arrow-left mr-1"></i>Retour
        </a>
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-folder mr-2 text-blue-700"></i>Créer un Projet
        </h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/projects">
            @csrf

            <div class="mb-4">
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

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-tag mr-1"></i>Nom du projet
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    placeholder="Ex: Site Web E-commerce"
                    required
                />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-align-left mr-1"></i>Description
                </label>
                <textarea
                    name="description"
                    rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    placeholder="Description du projet...">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-info-circle mr-1"></i>Statut
                </label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="planning">Planning</option>
                    <option value="active">Actif</option>
                    <option value="on_hold">En pause</option>
                    <option value="completed">Terminé</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-calendar mr-1"></i>Date de début
                    </label>
                    <input
                        type="date"
                        name="start_date"
                        value="{{ old('start_date') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    />
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-calendar-check mr-1"></i>Date de fin
                    </label>
                    <input
                        type="date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    />
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800">
                    <i class="fas fa-save mr-2"></i>Créer
                </button>
                <a href="/projects" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection