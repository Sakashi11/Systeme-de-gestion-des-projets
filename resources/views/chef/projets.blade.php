@extends('layouts.app')

@section('title', 'Projets du Chef de Projet')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-folder-open mr-2 text-blue-700"></i>Mes Projets
            </h1>
            <p class="text-sm text-gray-500">Tous les projets rattachés à vos équipes.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="/chef/dashboard" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Retour au dashboard</a>
            <a href="/chef/taches/create" class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">Nouvelle tâche</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($projects->isEmpty())
            <div class="p-10 text-center text-gray-500">
                <i class="fas fa-folder-open text-4xl mb-4"></i>
                <p>Aucun projet disponible pour vos équipes.</p>
            </div>
        @else
            <div class="w-full overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâches</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progression</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($projects as $project)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $project->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $project->team->name ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $project->tasks_count ?? $project->tasks->count() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold uppercase tracking-wide 
                                        @if($project->status == 'active') bg-green-100 text-green-700
                                        @elseif($project->status == 'planning') bg-yellow-100 text-yellow-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $project->progress }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
