@extends('layouts.app')

@section('title', 'Modifier la Tâche')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="/tasks" class="text-blue-700 hover:underline mr-4">
            <i class="fas fa-arrow-left mr-1"></i>Retour
        </a>
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-edit mr-2 text-blue-700"></i>Modifier la Tâche
        </h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/tasks/{{ $task->id }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-folder mr-1"></i>Projet
                </label>
                <select name="project_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-tag mr-1"></i>Titre
                </label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $task->title) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    required
                />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-align-left mr-1"></i>Description
                </label>
                <textarea
                    name="description"
                    rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-user mr-1"></i>Assigner à
                </label>
                <select name="assigned_to" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">Non assigné</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-info-circle mr-1"></i>Statut
                </label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>À faire</option>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>En cours</option>
                    <option value="review" {{ $task->status == 'review' ? 'selected' : '' }}>En revue</option>
                    <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Terminé</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-flag mr-1"></i>Priorité
                    </label>
                    <select name="priority" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                        <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Basse</option>
                        <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Moyenne</option>
                        <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Haute</option>
                        <option value="urgent" {{ $task->priority == 'urgent' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-calendar mr-1"></i>Échéance
                    </label>
                    <input
                        type="date"
                        name="due_date"
                        value="{{ old('due_date', $task->due_date) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                    />
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
                <a href="/tasks" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection