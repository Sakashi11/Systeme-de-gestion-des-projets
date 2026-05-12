@extends('layouts.app')

@section('title', 'Mes Équipes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-users mr-2 text-blue-700"></i>Mes Équipes
    </h1>
    <a href="/teams/create" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
        <i class="fas fa-plus mr-2"></i>Nouvelle Équipe
    </a>
</div>

@if($teams->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
        <p class="text-gray-500 text-lg">Aucune équipe pour le moment</p>
        <a href="/teams/create" class="mt-4 inline-block bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
            Créer une équipe
        </a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($teams as $team)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-lg font-bold text-gray-800">{{ $team->name }}</h2>
                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                    {{ $team->members->count() }} membres
                </span>
            </div>
            <p class="text-gray-500 text-sm mb-4">{{ $team->description ?? 'Aucune description' }}</p>
            <div class="flex items-center mb-4">
                <i class="fas fa-crown text-yellow-500 mr-2"></i>
                <span class="text-sm text-gray-600">{{ $team->owner->name }}</span>
            </div>
            <div class="flex gap-2">
                <a href="/teams/{{ $team->id }}" class="flex-1 text-center bg-blue-50 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-100 text-sm">
                    <i class="fas fa-eye mr-1"></i>Voir
                </a>
                <a href="/teams/{{ $team->id }}/edit" class="flex-1 text-center bg-yellow-50 text-yellow-700 px-3 py-2 rounded-lg hover:bg-yellow-100 text-sm">
                    <i class="fas fa-edit mr-1"></i>Modifier
                </a>
                <form method="POST" action="/teams/{{ $team->id }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Supprimer cette équipe ?')"
                        class="w-full bg-red-50 text-red-700 px-3 py-2 rounded-lg hover:bg-red-100 text-sm">
                        <i class="fas fa-trash mr-1"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection