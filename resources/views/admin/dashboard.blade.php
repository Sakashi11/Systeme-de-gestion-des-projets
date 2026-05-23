@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-shield-alt mr-2 text-blue-700"></i>Panel Administrateur
    </h1>
    <div class="flex gap-2">
        <a href="/admin/users" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 text-sm">
            <i class="fas fa-users mr-1"></i>Utilisateurs
        </a>
        <a href="/teams" class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 text-sm">
            <i class="fas fa-users-cog mr-1"></i>Équipes
        </a>
        <a href="/projects" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 text-sm">
            <i class="fas fa-folder mr-1"></i>Projets
        </a>
        <a href="/admin/reports" class="bg-purple-700 text-white px-4 py-2 rounded-lg hover:bg-purple-800 text-sm">
            <i class="fas fa-chart-bar mr-1"></i>Rapports
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-blue-600">{{ $stats['users'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Utilisateurs</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-green-600">{{ $stats['teams'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Équipes</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-yellow-600">{{ $stats['projects'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Projets</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-red-600">{{ $stats['tasks'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Tâches</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-3xl font-bold text-purple-600">{{ $stats['done'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Tâches terminées</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Utilisateurs récents --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-users mr-2 text-blue-700"></i>Derniers utilisateurs
        </h2>
        @foreach($recentUsers as $user)
        <div class="flex items-center justify-between py-2 border-b last:border-0">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                    <span class="text-blue-700 font-bold text-sm">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                </div>
            </div>
            <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
        </div>
        @endforeach
        <a href="/admin/users" class="mt-4 inline-block text-blue-700 hover:underline text-sm">
            Voir tous les utilisateurs →
        </a>
    </div>

    {{-- Projets récents --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-folder mr-2 text-blue-700"></i>Derniers projets
        </h2>
        @foreach($recentProjects as $project)
        <div class="flex items-center justify-between py-2 border-b last:border-0">
            <div>
                <p class="text-sm font-medium text-gray-800">{{ $project->name }}</p>
                <p class="text-xs text-gray-500">{{ $project->team->name }}</p>
            </div>
            <span class="text-xs px-2 py-1 rounded-full
                @if($project->status == 'active') bg-green-100 text-green-700
                @elseif($project->status == 'planning') bg-yellow-100 text-yellow-700
                @elseif($project->status == 'on_hold') bg-red-100 text-red-700
                @else bg-gray-100 text-gray-700 @endif">
                {{ $project->status }}
            </span>
        </div>
        @endforeach
        <a href="/projects" class="mt-4 inline-block text-blue-700 hover:underline text-sm">
            Voir tous les projets →
        </a>
    </div>
</div>
@endsection