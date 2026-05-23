@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Bonjour, {{ Auth::user()->name }} 👋
    </h1>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-3xl font-bold text-blue-600">{{ $stats['teams'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Équipes</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $stats['projects'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Projets</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['tasks'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Mes tâches</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <p class="text-3xl font-bold text-purple-600">{{ $stats['tasks_done'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Tâches terminées</p>
        </div>
    </div>

    {{-- Mes équipes --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Mes équipes</h2>
                <p class="text-sm text-gray-500">Équipes dont vous faites partie</p>
            </div>
            <a href="/teams" class="text-blue-700 hover:underline text-sm">Voir les équipes</a>
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
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Mes tâches récentes</h2>
        @forelse ($myTasks as $task)
            <div class="flex items-center justify-between py-2 border-b last:border-0">
                <span class="text-gray-800">{{ $task->title }}</span>
                <span class="text-xs px-2 py-1 rounded-full
                    {{ $task->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $task->status }}
                </span>
            </div>
        @empty
            <p class="text-gray-400 text-sm">Aucune tâche assignée pour le moment.</p>
        @endforelse
    </div>
</div>
@endsection