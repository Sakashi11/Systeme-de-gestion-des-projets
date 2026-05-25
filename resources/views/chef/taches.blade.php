@extends('layouts.app')

@section('title', 'Gestion des Tâches')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-tasks mr-2 text-blue-700"></i>Gestion des Tâches
        </h1>
        <p class="text-sm text-gray-500">Consultez vos tâches et créez-en rapidement depuis ici.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
        <a href="/chef/taches" class="rounded-lg border border-blue-700 bg-blue-700 px-4 py-2 text-sm font-medium text-white">Voir les tâches</a>
        <a href="/chef/taches/create" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Nouvelle tâche</a>
    </div>
</div>

@if($tasks->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <i class="fas fa-tasks text-gray-300 text-6xl mb-4"></i>
        <p class="text-gray-500 text-lg">Aucune tâche pour le moment</p>
        <a href="/chef/taches/create" class="mt-4 inline-block bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
            Créer une tâche
        </a>
    </div>
@else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâche</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigné à</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priorité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Échéance</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($tasks as $task)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800">{{ $task->title }}</p>
                        <p class="text-xs text-gray-500">{{ $task->description }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $task->project->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $task->assignee->name ?? 'Non assigné' }}
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
                    <td class="px-6 py-4">
                        @if(Auth::id() === $task->assigned_to)
                        <form method="POST" action="/chef/taches/{{ $task->id }}">
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
                        @else
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($task->status == 'done') bg-green-100 text-green-700
                            @elseif($task->status == 'in_progress') bg-blue-100 text-blue-700
                            @elseif($task->status == 'review') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif">
                            @if($task->status == 'todo') À faire
                            @elseif($task->status == 'in_progress') En cours
                            @elseif($task->status == 'review') En revue
                            @elseif($task->status == 'done') Terminé
                            @else {{ $task->status }} @endif
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $task->due_date ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <form method="POST" action="/chef/taches/{{ $task->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Supprimer cette tâche ?')"
                                class="text-red-600 hover:text-red-800 text-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection