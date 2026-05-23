@extends('layouts.app')

@section('title', 'Mes Projets')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-folder mr-2 text-blue-700"></i>Mes Projets
    </h1>
    <a href="/membre/dashboard" class="text-blue-700 hover:underline text-sm">
        <i class="fas fa-arrow-left mr-1"></i>Retour
    </a>
</div>

@if($projects->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <i class="fas fa-folder-open text-gray-300 text-6xl mb-4"></i>
        <p class="text-gray-500 text-lg">Vous n'avez accès à aucun projet pour le moment.</p>
        <p class="text-gray-400 text-sm mt-2">Contactez un chef de projet pour être ajouté à une équipe.</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($projects as $project)
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex justify-between items-start mb-3">
                <h2 class="text-lg font-bold text-gray-800">{{ $project->name }}</h2>
                <span class="text-xs px-2 py-1 rounded-full font-medium
                    @if($project->status == 'active') bg-green-100 text-green-700
                    @elseif($project->status == 'planning') bg-yellow-100 text-yellow-700
                    @elseif($project->status == 'on_hold') bg-red-100 text-red-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ $project->status }}
                </span>
            </div>

            <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $project->description ?? 'Aucune description' }}</p>

            <!-- Progression -->
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Progression</span>
                    <span class="font-semibold">{{ $project->progress }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-700 h-2 rounded-full transition-all duration-300" style="width: {{ $project->progress }}%"></div>
                </div>
            </div>

            <div class="text-xs text-gray-500 mb-4 space-y-1">
                <div><i class="fas fa-users mr-1"></i>{{ $project->team->name }}</div>
                <div>
                    <i class="fas fa-tasks mr-1"></i>{{ $project->tasks->count() }} tâche(s)
                    @if($project->tasks->where('assigned_to', Auth::id())->count() > 0)
                        <span class="text-blue-600">({{ $project->tasks->where('assigned_to', Auth::id())->count() }} pour vous)</span>
                    @endif
                </div>
                @if($project->start_date)
                    <div><i class="fas fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</div>
                @endif
            </div>

            <a href="/membre/projets/{{ $project->id }}" class="block w-full text-center bg-blue-700 text-white px-3 py-2 rounded-lg hover:bg-blue-800 text-sm font-medium transition">
                <i class="fas fa-eye mr-1"></i>Voir le projet
            </a>
        </div>
        @endforeach
    </div>
@endif
@endsection
