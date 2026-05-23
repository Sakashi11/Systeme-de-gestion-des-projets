@extends('layouts.app')

@section('title', 'Dashboard Chef de Projet')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-user-tie mr-2 text-blue-700"></i>Bonjour, {{ $user->prenom }} {{ $user->name }} !
    </h1>
    <p class="text-gray-500 mt-1">Dashboard Chef de Projet</p>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-blue-600">{{ $stats['teams'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Mes Équipes</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-green-600">{{ $stats['projects'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Projets</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-yellow-600">{{ $stats['tasks'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Tâches</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-purple-600">{{ $stats['membres'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Membres</p>
    </div>
</div>

{{-- Actions rapides --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <a href="/chef/taches/create" class="bg-blue-700 text-white rounded-lg shadow p-6 text-center hover:bg-blue-800">
        <i class="fas fa-tasks text-4xl mb-3"></i>
        <p class="font-semibold">Nouvelle Tâche</p>
    </a>
    <a href="/chef/taches" class="bg-green-700 text-white rounded-lg shadow p-6 text-center hover:bg-green-800">
        <i class="fas fa-list text-4xl mb-3"></i>
        <p class="font-semibold">Voir les Tâches</p>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Tâches récentes --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-tasks mr-2 text-blue-700"></i>Tâches récentes
        </h2>
        @forelse($myTasks as $task)
        <div class="flex items-center justify-between py-2 border-b last:border-0">
            <div class="flex items-center">
                <span class="w-3 h-3 rounded-full mr-3
                    @if($task->status == 'done') bg-green-500
                    @elseif($task->status == 'in_progress') bg-blue-500
                    @elseif($task->status == 'review') bg-yellow-500
                    @else bg-gray-300 @endif">
                </span>
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $task->title }}</p>
                    <p class="text-xs text-gray-500">
                        {{ $task->project->name ?? '-' }}
                        @if($task->assignee)
                            → {{ $task->assignee->prenom }} {{ $task->assignee->name }}
                        @endif
                    </p>
                </div>
            </div>
            <span class="text-xs px-2 py-1 rounded-full
                @if($task->priority == 'urgent') bg-red-100 text-red-700
                @elseif($task->priority == 'high') bg-orange-100 text-orange-700
                @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-700
                @else bg-gray-100 text-gray-700 @endif">
                {{ $task->priority }}
            </span>
        </div>
        @empty
            <p class="text-gray-500 text-sm">Aucune tâche</p>
        @endforelse
        <a href="/chef/taches" class="mt-4 inline-block text-blue-700 hover:underline text-sm">
            Voir toutes les tâches →
        </a>
    </div>

    {{-- Projets récents --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-folder mr-2 text-blue-700"></i>Projets récents
        </h2>
        @forelse($projects as $project)
        <div class="py-2 border-b last:border-0">
            <div class="flex justify-between items-center mb-1">
                <p class="text-sm font-medium text-gray-800">{{ $project->name }}</p>
                <span class="text-xs px-2 py-1 rounded-full
                    @if($project->status == 'active') bg-green-100 text-green-700
                    @elseif($project->status == 'planning') bg-yellow-100 text-yellow-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ $project->status }}
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-1.5">
                <div class="bg-blue-700 h-1.5 rounded-full" style="width: {{ $project->progress }}%"></div>
            </div>
        </div>
        @empty
            <p class="text-gray-500 text-sm">Aucun projet</p>
        @endforelse
    </div>
</div>
@endsection