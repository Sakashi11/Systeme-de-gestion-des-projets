@extends('layouts.app')

@section('title', 'Mes Tâches')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-tasks mr-2 text-blue-700"></i>Mes Tâches
    </h1>
    <a href="/tasks/create" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
        <i class="fas fa-plus mr-2"></i>Nouvelle Tâche
    </a>
</div>

@if($tasks->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <i class="fas fa-tasks text-gray-300 text-6xl mb-4"></i>
        <p class="text-gray-500 text-lg">Aucune tâche pour le moment</p>
        <a href="/tasks/create" class="mt-4 inline-block bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
            Créer une tâche
        </a>
    </div>
@else
    <!-- Filtres -->
    <div class="flex gap-2 mb-6">
        <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm cursor-pointer hover:bg-gray-300">Toutes</span>
        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm cursor-pointer hover:bg-blue-200">En cours</span>
        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm cursor-pointer hover:bg-green-200">Terminées</span>
        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm cursor-pointer hover:bg-yellow-200">En revue</span>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâche</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priorité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Échéance</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($tasks as $task)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <a href="/tasks/{{ $task->id }}" class="font-medium text-gray-800 hover:text-blue-700">
                            {{ $task->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $task->project->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($task->status == 'done') bg-green-100 text-green-700
                            @elseif($task->status == 'in_progress') bg-blue-100 text-blue-700
                            @elseif($task->status == 'review') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $task->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($task->priority == 'urgent') bg-red-100 text-red-700
                            @elseif($task->priority == 'high') bg-orange-100 text-orange-700
                            @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $task->priority }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $task->due_date ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="/tasks/{{ $task->id }}/edit" class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="/tasks/{{ $task->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Supprimer cette tâche ?')"
                                    class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection