@extends('layouts.app')

@section('title', 'Dashboard Chef de Projet')

@section('content')
<div class="space-y-8">
    {{-- En-tête avec bienvenue et actions --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-800 to-indigo-600 bg-clip-text text-transparent">
                Bonjour, {{ $user->prenom }} {{ $user->name }}
            </h1>
            <p class="text-gray-500 mt-1 flex items-center gap-1">
                <i class="fas fa-chart-line text-sm"></i>
                Tableau de bord – Chef de Projet
            </p>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex items-center gap-3">
                <a href="/chef/membres" class="text-sm font-medium text-blue-600 hover:text-blue-800">Mes équipes</a>
                <a href="/chef/projets" class="text-sm font-medium text-blue-600 hover:text-blue-800">Projets</a>
                <a href="/chef/taches" class="text-sm font-medium text-blue-600 hover:text-blue-800">Tâches</a>
            </div>
            <a href="/chef/taches/create" class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">
                <i class="fas fa-plus mr-2"></i>Nouvelle tâche
            </a>
        </div>
    </div>

    {{-- Cartes statistiques avec icônes et évolution --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md hover:-translate-y-0.5 duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Mes Équipes</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['teams'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs">
                <span class="text-green-500"><i class="fas fa-arrow-up"></i> +2</span>
                <span class="text-gray-400 ml-2">vs mois dernier</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md hover:-translate-y-0.5 duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Projets</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['projects'] }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-folder-open text-emerald-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs">
                <span class="text-emerald-500"><i class="fas fa-check-circle"></i> {{ $stats['projects_active'] ?? 3 }} actifs</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md hover:-translate-y-0.5 duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Tâches</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['tasks'] }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-list-check text-amber-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs gap-2">
                <span class="text-green-500"><i class="fas fa-check-circle"></i> {{ $stats['tasks_done'] ?? 0 }} terminées</span>
                <span class="text-blue-500"><i class="fas fa-spinner"></i> {{ $stats['tasks_progress'] ?? 0 }} en cours</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md hover:-translate-y-0.5 duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Membres</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['membres'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-user-plus text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs">
                <div class="flex -space-x-2">
                    @for($i = 0; $i < min(3, $stats['membres']); $i++)
                        <div class="w-6 h-6 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-[10px] font-bold text-gray-600">U</div>
                    @endfor
                    @if($stats['membres'] > 3)
                        <div class="w-6 h-6 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-gray-600">+{{ $stats['membres']-3 }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Actions rapides améliorées --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="/chef/taches/create" class="group relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative flex items-center gap-4">
                <i class="fas fa-tasks text-4xl opacity-80 group-hover:scale-110 transition-transform"></i>
                <div>
                    <p class="text-xl font-bold">Nouvelle Tâche</p>
                    <p class="text-sm text-blue-100">Ajouter une tâche à un projet</p>
                </div>
                <i class="fas fa-arrow-right ml-auto opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all"></i>
            </div>
        </a>
        <a href="/chef/taches" class="group relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-700 p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative flex items-center gap-4">
                <i class="fas fa-list-ul text-4xl opacity-80 group-hover:scale-110 transition-transform"></i>
                <div>
                    <p class="text-xl font-bold">Voir les Tâches</p>
                    <p class="text-sm text-emerald-100">Gérer le suivi global</p>
                </div>
                <i class="fas fa-arrow-right ml-auto opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all"></i>
            </div>
        </a>
    </div>

    {{-- Mes équipes --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-users text-blue-600"></i>
                Mes équipes
            </h2>
            <a href="/teams" class="text-blue-600 hover:text-blue-800 text-sm">Voir toutes</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($teams as $team)
                <div class="rounded-2xl border border-gray-100 p-4 bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-800">{{ $team->name }}</h3>
                        <span class="text-xs text-slate-500">{{ $team->members->count() }} membres</span>
                    </div>
                    <p class="text-xs text-gray-500">{{ $team->description ?? 'Aucune description' }}</p>
                    <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                        <span>{{ $team->projects->count() }} projets</span>
                        <span>{{ $team->members->count() }} membres</span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-gray-400">
                    Vous ne gérez aucune équipe actuellement.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Section principale avec graphique et listes --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Graphique de progression des tâches (style circulaire) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-1">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-blue-600"></i>
                Avancement global
            </h2>
            <div class="flex flex-col items-center">
                <div class="relative w-36 h-36 mb-4">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#e2e8f0" stroke-width="12"></circle>
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#3b82f6" stroke-width="12" stroke-dasharray="{{ ($stats['tasks_done'] ?? 0) / max($stats['tasks'],1) * 339.3 }} 339.3" stroke-linecap="round"></circle>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-bold text-gray-800">{{ round(($stats['tasks_done'] ?? 0) / max($stats['tasks'],1) * 100) }}%</span>
                        <span class="text-xs text-gray-500">complétées</span>
                    </div>
                </div>
                <div class="flex gap-4 text-xs">
                    <div><span class="inline-block w-3 h-3 rounded-full bg-green-500"></span> Terminées</div>
                    <div><span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span> En cours</div>
                    <div><span class="inline-block w-3 h-3 rounded-full bg-gray-300"></span> À faire</div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Progression moyenne des projets</span>
                    <span class="font-medium">{{ $stats['avg_progress'] ?? 68 }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $stats['avg_progress'] ?? 68 }}%"></div>
                </div>
            </div>
        </div>

        {{-- Tâches récentes (style moderne) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-clock text-blue-600"></i>
                    Tâches récentes
                </h2>
                <a href="/chef/taches" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                    Toutes les tâches <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            <div class="space-y-3">
                @forelse($myTasks as $task)
                <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-all border border-transparent hover:border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full
                            @if($task->status == 'done') bg-green-500
                            @elseif($task->status == 'in_progress') bg-blue-500 animate-pulse
                            @elseif($task->status == 'review') bg-yellow-500
                            @else bg-gray-400 @endif">
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800 group-hover:text-blue-700 transition">{{ $task->title }}</p>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-400">
                                <span><i class="far fa-folder-open mr-1"></i>{{ $task->project->name ?? 'Sans projet' }}</span>
                                @if($task->assignee)
                                <span><i class="far fa-user mr-1"></i>{{ $task->assignee->prenom }} {{ $task->assignee->name }}</span>
                                @endif
                                <span><i class="far fa-calendar-alt mr-1"></i>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m') : 'Pas de date' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-2 sm:mt-0">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            @if($task->priority == 'urgent') bg-red-100 text-red-700
                            @elseif($task->priority == 'high') bg-orange-100 text-orange-700
                            @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-600 @endif">
                            {{ ucfirst($task->priority) }}
                        </span>
                        <span class="text-xs px-2.5 py-1 rounded-full bg-gray-100 text-gray-600">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                </div>
                @empty
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-check-circle text-3xl mb-2 opacity-50"></i>
                        <p>Aucune tâche enregistrée</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Projets récents avec barre de progression détaillée --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-chart-simple text-blue-600"></i>
                Projets en cours
            </h2>
            <a href="/chef/projets" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Voir tous →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @forelse($projects as $project)
            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/30 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $project->name }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Débuté le {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') : '—' }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full
                        @if($project->status == 'active') bg-green-100 text-green-700
                        @elseif($project->status == 'planning') bg-yellow-100 text-yellow-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>
                <div class="mt-3">
                    <div class="flex justify-between text-xs mb-1">
                        <span>Progression</span>
                        <span class="font-medium">{{ $project->progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $project->progress }}%"></div>
                    </div>
                </div>
                <div class="mt-3 flex justify-between items-center text-xs text-gray-500">
                    <span><i class="far fa-clock mr-1"></i> {{ $project->tasks_count ?? 0 }} tâches</span>
                    <span><i class="fas fa-users mr-1"></i> {{ $project->team->name ?? 'Équipe non assignée' }}</span>
                </div>
            </div>
            @empty
                <div class="col-span-2 text-center py-8 text-gray-400">
                    <i class="fas fa-folder-open text-3xl mb-2 opacity-50"></i>
                    <p>Aucun projet récent</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

{{-- Ajout d'un petit style personnalisé pour l'animation du SVG (optionnel) --}}
@push('styles')
<style>
    /* Animation subtile pour la barre de progression */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    .group:hover .group-hover\:translate-x-0 {
        transform: translateX(0);
    }
</style>
@endpush