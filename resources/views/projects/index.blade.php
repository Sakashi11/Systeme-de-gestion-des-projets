@extends('layouts.app')

@section('title', 'Mes Projets')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-folder mr-2 text-blue-700"></i>Mes Projets
    </h1>
    <a href="/projects/create" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
        <i class="fas fa-plus mr-2"></i>Nouveau Projet
    </a>
</div>

@if($projects->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <i class="fas fa-folder-open text-gray-300 text-6xl mb-4"></i>
        <p class="text-gray-500 text-lg">Aucun projet pour le moment</p>
        <a href="/projects/create" class="mt-4 inline-block bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
            Créer un projet
        </a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($projects as $project)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-3">
                <h2 class="text-lg font-bold text-gray-800">{{ $project->name }}</h2>
                <span class="text-xs px-2 py-1 rounded-full
                    @if($project->status == 'active') bg-green-100 text-green-700
                    @elseif($project->status == 'planning') bg-yellow-100 text-yellow-700
                    @elseif($project->status == 'on_hold') bg-red-100 text-red-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ $project->status }}
                </span>
            </div>

            <p class="text-gray-500 text-sm mb-4">{{ $project->description ?? 'Aucune description' }}</p>

            <!-- Progression -->
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Progression</span>
                    <span>{{ $project->progress }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-700 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
                </div>
            </div>

            <div class="text-xs text-gray-500 mb-4">
                <i class="fas fa-users mr-1"></i>{{ $project->team->name }}
            </div>

            <div class="flex gap-2">
                <a href="/projects/{{ $project->id }}" class="flex-1 text-center bg-blue-50 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-100 text-sm">
                    <i class="fas fa-eye mr-1"></i>Voir
                </a>
                <a href="/projects/{{ $project->id }}/edit" class="flex-1 text-center bg-yellow-50 text-yellow-700 px-3 py-2 rounded-lg hover:bg-yellow-100 text-sm">
                    <i class="fas fa-edit mr-1"></i>Modifier
                </a>
                <form method="POST" action="/projects/{{ $project->id }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Supprimer ce projet ?')"
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