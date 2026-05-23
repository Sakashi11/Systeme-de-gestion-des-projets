@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-user mr-2 text-blue-700"></i>Bonjour, {{ $user->name }} !
    </h1>
    <p class="text-gray-500 mt-1">Voici vos tâches et activités</p>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-blue-600">{{ $stats['teams'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Mes Équipes</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-yellow-600">{{ $stats['tasks'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Mes Tâches</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-green-600">{{ $stats['tasks_done'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Terminées</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-orange-600">{{ $stats['in_progress'] }}</p>
        <p class="text-sm text-gray-500 mt-1">En cours</p>
    </div>
</div>

{{-- Mes équipes --}}
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Mes équipes</h2>
            <p class="text-sm text-gray-500">Équipes dans lesquelles vous êtes membre</p>
        </div>
        <div class="flex gap-2">
            <a href="/messages" class="text-blue-700 hover:underline text-sm">Messagerie</a>
            <a href="/membre/projets" class="bg-blue-700 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-800">Voir les projets</a>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($teams as $team)
            <div class="rounded-xl border border-slate-200 p-4 bg-slate-50">
                <h3 class="font-semibold text-gray-800">{{ $team->name }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $team->description ?? 'Aucune description' }}</p>
                <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                    <span>{{ $team->members->count() }} membre(s)</span>
                    <span>{{ $team->projects->count() }} projet(s)</span>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-gray-500">
                Vous ne faites partie d'aucune équipe pour le moment.
            </div>
        @endforelse
    </div>
</div>

{{-- Tâches récentes --}}
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">
        <i class="fas fa-tasks mr-2 text-blue-700"></i>Mes tâches récentes
    </h2>
    @forelse($myTasks as $task)
    <div class="flex items-center justify-between py-3 border-b last:border-0">
        <div class="flex items-center">
            <span class="w-3 h-3 rounded-full mr-3
                @if($task->status == 'done') bg-green-500
                @elseif($task->status == 'in_progress') bg-blue-500
                @elseif($task->status == 'review') bg-yellow-500
                @else bg-gray-300 @endif">
            </span>
            <div>
                <a href="/tasks/{{ $task->id }}" class="text-sm font-medium text-gray-800 hover:text-blue-700">
                    {{ $task->title }}
                </a>
                <p class="text-xs text-gray-500">{{ $task->project->name ?? '-' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs px-2 py-1 rounded-full
                @if($task->priority == 'urgent') bg-red-100 text-red-700
                @elseif($task->priority == 'high') bg-orange-100 text-orange-700
                @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-700
                @else bg-gray-100 text-gray-700 @endif">
                {{ $task->priority }}
            </span>
            <!-- Changer statut -->
            <form method="POST" action="/membre/taches/{{ $task->id }}">
                @csrf
                @method('PATCH')
                <select name="status" onchange="this.form.submit()"
                    class="text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none">
                    <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>À faire</option>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>En cours</option>
                    <option value="review" {{ $task->status == 'review' ? 'selected' : '' }}>En revue</option>
                    <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Terminé</option>
                </select>
            </form>
        </div>
    </div>
    @empty
        <p class="text-gray-500 text-sm">Aucune tâche assignée</p>
    @endforelse
    <a href="/membre/taches" class="mt-4 inline-block text-blue-700 hover:underline text-sm">
        Voir toutes mes tâches →
    </a>
</div>
@endsection