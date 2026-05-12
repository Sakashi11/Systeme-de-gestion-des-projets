@extends('layouts.app')

@section('title', 'Gestion des Projets')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-folder mr-2 text-blue-700"></i>Gestion des Projets
    </h1>
    <a href="/admin/dashboard" class="text-blue-700 hover:underline">
        <i class="fas fa-arrow-left mr-1"></i>Retour
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projet</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipe</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâches</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progression</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($projects as $project)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-800">{{ $project->name }}</p>
                    <p class="text-xs text-gray-500">{{ $project->description ?? '-' }}</p>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $project->team->name }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full
                        @if($project->status == 'active') bg-green-100 text-green-700
                        @elseif($project->status == 'planning') bg-yellow-100 text-yellow-700
                        @elseif($project->status == 'on_hold') bg-red-100 text-red-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ $project->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $project->tasks_count }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-700 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
                        </div>
                        <span class="text-xs text-gray-500">{{ $project->progress }}%</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <form method="POST" action="/admin/projects/{{ $project->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Supprimer ce projet ?')"
                            class="text-red-600 hover:text-red-800 text-sm">
                            <i class="fas fa-trash mr-1"></i>Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection