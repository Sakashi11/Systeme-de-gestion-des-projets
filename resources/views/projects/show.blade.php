@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="flex items-center mb-6">
    <a href="/projects" class="text-blue-700 hover:underline mr-4">
        <i class="fas fa-arrow-left mr-1"></i>Retour
    </a>
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-folder mr-2 text-blue-700"></i>{{ $project->name }}
    </h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

    <!-- Infos projet -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations</h2>
        <p class="text-gray-500 text-sm mb-4">{{ $project->description ?? 'Aucune description' }}</p>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Statut</span>
                <span class="font-medium">{{ $project->status }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Équipe</span>
                <span class="font-medium">{{ $project->team->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Début</span>
                <span class="font-medium">{{ $project->start_date ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Fin</span>
                <span class="font-medium">{{ $project->end_date ?? '-' }}</span>
            </div>
        </div>

        <!-- Progression -->
        <div class="mt-4">
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Progression</span>
                <span>{{ $project->progress }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-700 h-3 rounded-full" style="width: {{ $project->progress }}%"></div>
            </div>
        </div>
    </div>

    <!-- Tâches -->
    <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Tâches</h2>
            <a href="/tasks/create" class="bg-blue-700 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-800">
                <i class="fas fa-plus mr-1"></i>Nouvelle tâche
            </a>
        </div>

        @forelse($project->tasks as $task)
        <div class="flex items-center justify-between py-3 border-b last:border-0">
            <div class="flex items-center">
                <span class="w-3 h-3 rounded-full mr-3
                    @if($task->status == 'done') bg-green-500
                    @elseif($task->status == 'in_progress') bg-blue-500
                    @elseif($task->status == 'review') bg-yellow-500
                    @else bg-gray-300 @endif">
                </span>
                <div>
                    <a href="/tasks/{{ $task->id }}" class="text-gray-800 font-medium hover:text-blue-700">
                        {{ $task->title }}
                    </a>
                    @if($task->assignee)
                        <p class="text-xs text-gray-500">{{ $task->assignee->name }}</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs px-2 py-1 rounded-full
                    @if($task->priority == 'urgent') bg-red-100 text-red-700
                    @elseif($task->priority == 'high') bg-orange-100 text-orange-700
                    @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ $task->priority }}
                </span>
                <a href="/tasks/{{ $task->id }}/edit" class="text-yellow-600 hover:text-yellow-800">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
        @empty
            <p class="text-gray-500 text-sm">Aucune tâche pour ce projet</p>
        @endforelse
    </div>
</div>
@endsection