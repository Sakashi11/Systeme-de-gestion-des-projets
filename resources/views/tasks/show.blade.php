@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="flex items-center mb-6">
    <a href="/tasks" class="text-blue-700 hover:underline mr-4">
        <i class="fas fa-arrow-left mr-1"></i>Retour
    </a>
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-tasks mr-2 text-blue-700"></i>{{ $task->title }}
    </h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Infos tâche -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations</h2>
        <p class="text-gray-500 text-sm mb-4">{{ $task->description ?? 'Aucune description' }}</p>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Statut</span>
                <span class="px-2 py-1 rounded-full text-xs
                    @if($task->status == 'done') bg-green-100 text-green-700
                    @elseif($task->status == 'in_progress') bg-blue-100 text-blue-700
                    @elseif($task->status == 'review') bg-yellow-100 text-yellow-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ $task->status }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Priorité</span>
                <span class="px-2 py-1 rounded-full text-xs
                    @if($task->priority == 'urgent') bg-red-100 text-red-700
                    @elseif($task->priority == 'high') bg-orange-100 text-orange-700
                    @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ $task->priority }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Projet</span>
                <span class="font-medium">{{ $task->project->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Assigné à</span>
                <span class="font-medium">{{ $task->assignee->name ?? 'Non assigné' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Créé par</span>
                <span class="font-medium">{{ $task->creator->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Échéance</span>
                <span class="font-medium">{{ $task->due_date ?? '-' }}</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="/tasks/{{ $task->id }}/edit" class="w-full block text-center bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 text-sm">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
        </div>
    </div>

    <!-- Commentaires -->
    <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-comments mr-2"></i>Commentaires
        </h2>

        @forelse($task->comments as $comment)
        <div class="flex gap-3 mb-4">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-blue-700 font-bold text-sm">{{ substr($comment->user->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 bg-gray-50 rounded-lg p-3">
                <div class="flex justify-between mb-1">
                    <span class="font-medium text-sm text-gray-800">{{ $comment->user->name }}</span>
                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-600 text-sm">{{ $comment->content }}</p>
            </div>
        </div>
        @empty
            <p class="text-gray-500 text-sm mb-4">Aucun commentaire</p>
        @endforelse

        <!-- Ajouter commentaire -->
        <form method="POST" action="/tasks/{{ $task->id }}/comments" class="mt-4">
            @csrf
            <textarea
                name="content"
                rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 text-sm"
                placeholder="Ajouter un commentaire..."></textarea>
            <button type="submit" class="mt-2 bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 text-sm">
                <i class="fas fa-paper-plane mr-2"></i>Envoyer
            </button>
        </form>
    </div>
</div>
@endsection