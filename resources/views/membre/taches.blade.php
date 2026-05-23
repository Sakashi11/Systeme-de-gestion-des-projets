@extends('layouts.app')

@section('title', 'Mes Tâches')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-tasks mr-2 text-blue-700"></i>Mes Tâches
    </h1>
</div>

@if($tasks->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <i class="fas fa-tasks text-gray-300 text-6xl mb-4"></i>
        <p class="text-gray-500 text-lg">Aucune tâche assignée</p>
    </div>
@else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâche</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priorité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Échéance</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
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
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $task->project->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($task->priority == 'urgent') bg-red-100 text-red-700
                            @elseif($task->priority == 'high') bg-orange-100 text-orange-700
                            @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $task->priority }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $task->due_date ?? '-' }}</td>
                    <td class="px-6 py-4">
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
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection