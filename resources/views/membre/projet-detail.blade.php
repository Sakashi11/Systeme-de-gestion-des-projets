@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="flex items-center mb-6">
    <a href="/membre/projets" class="text-blue-700 hover:underline mr-4">
        <i class="fas fa-arrow-left mr-1"></i>Retour
    </a>
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-folder mr-2 text-blue-700"></i>{{ $project->name }}
    </h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

    <!-- Infos projet -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-info-circle text-blue-600 mr-2"></i>Informations
        </h2>
        <p class="text-gray-500 text-sm mb-4">{{ $project->description ?? 'Aucune description' }}</p>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Statut</span>
                <span class="font-medium px-2 py-1 rounded-full text-xs
                    @if($project->status == 'active') bg-green-100 text-green-700
                    @elseif($project->status == 'planning') bg-yellow-100 text-yellow-700
                    @elseif($project->status == 'on_hold') bg-red-100 text-red-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ $project->status }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Équipe</span>
                <span class="font-medium">{{ $project->team->name }}</span>
            </div>
            @if($project->start_date)
            <div class="flex justify-between">
                <span class="text-gray-500">Début</span>
                <span class="font-medium">{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</span>
            </div>
            @endif
            @if($project->end_date)
            <div class="flex justify-between">
                <span class="text-gray-500">Fin</span>
                <span class="font-medium">{{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}</span>
            </div>
            @endif
        </div>

        <!-- Progression -->
        <div class="mt-4">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Progression générale</span>
                <span class="font-bold text-blue-700">{{ $project->progress }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-700 h-3 rounded-full transition-all duration-300" style="width: {{ $project->progress }}%"></div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="mt-6 pt-6 border-t space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Total tâches</span>
                <span class="font-bold text-gray-800">{{ $project->tasks->count() }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Tâches pour vous</span>
                <span class="font-bold text-blue-700">{{ $project->tasks->where('assigned_to', Auth::id())->count() }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Tâches terminées</span>
                <span class="font-bold text-green-700">{{ $project->tasks->where('status', 'done')->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Tâches -->
    <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
        <div class="flex items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700 flex-1">
                <i class="fas fa-tasks text-blue-600 mr-2"></i>Tâches du projet
            </h2>
            <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium">{{ $project->tasks->count() }} tâches</span>
        </div>

        @forelse($project->tasks as $task)
        <div class="flex items-start gap-3 py-4 px-4 rounded-lg mb-2 border border-gray-200 hover:border-blue-200 hover:bg-blue-50 transition">
            <div class="flex-shrink-0 mt-1">
                <div class="w-3 h-3 rounded-full
                    @if($task->status == 'done') bg-green-500
                    @elseif($task->status == 'in_progress') bg-blue-500
                    @elseif($task->status == 'review') bg-yellow-500
                    @else bg-gray-300 @endif">
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <a href="/tasks/{{ $task->id }}" class="text-gray-800 font-medium hover:text-blue-700 block">
                    {{ $task->title }}
                </a>
                <div class="text-xs text-gray-500 mt-1 flex flex-wrap gap-2 items-center">
                    @if($task->assigned_to)
                        <span class="inline-block">
                            <i class="fas fa-user mr-1"></i>
                            @if($task->assigned_to === Auth::id())
                                <strong>Vous</strong>
                            @else
                                {{ $task->assignee->name }}
                            @endif
                        </span>
                    @else
                        <span class="text-gray-400">Non assignée</span>
                    @endif
                    @if($task->due_date)
                        <span class="inline-block">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="text-xs px-2 py-1 rounded-full font-medium
                    @if($task->priority == 'urgent') bg-red-100 text-red-700
                    @elseif($task->priority == 'high') bg-orange-100 text-orange-700
                    @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ ucfirst($task->priority) }}
                </span>
                <span class="text-xs px-2 py-1 rounded-full font-medium
                    @if($task->status == 'done') bg-green-50 text-green-700 border border-green-100
                    @elseif($task->status == 'in_progress') bg-blue-50 text-blue-700 border border-blue-100
                    @elseif($task->status == 'review') bg-yellow-50 text-yellow-700 border border-yellow-100
                    @else bg-gray-50 text-gray-600 border border-gray-100 @endif">
                    @if($task->status == 'todo') À faire
                    @elseif($task->status == 'in_progress') En cours
                    @elseif($task->status == 'review') En revue
                    @elseif($task->status == 'done') Terminé
                    @else {{ ucfirst(str_replace('_', ' ', $task->status)) }} @endif
                </span>
            </div>
        </div>
        @empty
            <div class="text-center py-12 text-gray-400">
                <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                <p>Aucune tâche dans ce projet</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Filtres optionnels -->
<div class="bg-white rounded-lg shadow p-6 mt-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">
        <i class="fas fa-filter text-blue-600 mr-2"></i>Mes tâches dans ce projet
    </h2>
    
    @php
        $myTasks = $project->tasks->where('assigned_to', Auth::id());
    @endphp
    
    @if($myTasks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($myTasks as $task)
            <div class="p-4 border-l-4 rounded-lg
                @if($task->status == 'done') border-green-500 bg-green-50
                @elseif($task->status == 'in_progress') border-blue-500 bg-blue-50
                @elseif($task->status == 'review') border-yellow-500 bg-yellow-50
                @else border-gray-400 bg-gray-50 @endif">
                <h3 class="font-semibold text-gray-800 mb-2">{{ $task->title }}</h3>
                <div class="text-xs text-gray-600 space-y-1 mb-3">
                    <p><i class="fas fa-flag mr-1"></i>Priorité: {{ ucfirst($task->priority) }}</p>
                    <p><i class="fas fa-circle-notch mr-1"></i>Statut: {{ ucfirst(str_replace('_', ' ', $task->status)) }}</p>
                    @if($task->due_date)
                        <p><i class="fas fa-calendar mr-1"></i>Échéance: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</p>
                    @endif
                </div>
                <a href="/tasks/{{ $task->id }}" class="text-xs text-blue-700 hover:underline font-medium">
                    Voir les détails →
                </a>
            </div>
            @empty
                <p class="text-gray-500">Vous n'avez aucune tâche assignée dans ce projet</p>
            @endforelse
        </div>
    @else
        <p class="text-gray-500 text-center py-8">
            Vous n'avez aucune tâche assignée dans ce projet pour le moment.
        </p>
    @endif
</div>
@endsection
