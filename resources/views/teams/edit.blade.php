@extends('layouts.app')

@section('title', 'Modifier l\'équipe')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="/teams" class="text-blue-700 hover:underline mr-4">
            <i class="fas fa-arrow-left mr-1"></i>Retour
        </a>
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-edit mr-2 text-blue-700"></i>Modifier l'équipe
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

        <form method="POST" action="/teams/{{ $team->id }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-crown text-yellow-500 mr-1"></i>Propriétaire / Chef de Projet
                </label>
                <select name="owner_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('owner_id', $team->owner_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->role }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-tag mr-1"></i>Nom de l'équipe
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $team->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    required
                />
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-align-left mr-1"></i>Description
                </label>
                <textarea
                    name="description"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">{{ old('description', $team->description) }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
                <a href="/teams" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection