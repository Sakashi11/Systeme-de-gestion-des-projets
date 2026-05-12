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