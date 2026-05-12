@extends('layouts.app')

@section('title', $team->name)

@section('content')
<div class="flex items-center mb-6">
    <a href="/teams" class="text-blue-700 hover:underline mr-4">
        <i class="fas fa-arrow-left mr-1"></i>Retour
    </a>
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-users mr-2 text-blue-700"></i>{{ $team->name }}
    </h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Infos équipe -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations</h2>
        <p class="text-gray-500 mb-4">{{ $team->description ?? 'Aucune description' }}</p>
        <div class="flex items-center mb-2">
            <i class="fas fa-crown text-yellow-500 mr-2"></i>
            <span class="text-sm text-gray-600">Propriétaire : {{ $team->owner->name }}</span>
        </div>
        <div class="flex items-center">
            <i class="fas fa-users text-blue-500 mr-2"></i>
            <span class="text-sm text-gray-600">{{ $team->members->count() }} membres</span>
        </div>
    </div>

    <!-- Membres -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Membres</h2>
        @foreach($team->members as $member)
        <div class="flex items-center justify-between py-2 border-b last:border-0">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                    <span class="text-blue-700 font-bold text-sm">{{ substr($member->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $member->name }}</p>
                    <p class="text-xs text-gray-500">{{ $member->pivot->role }}</p>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Ajouter membre -->
        <form method="POST" action="/teams/{{ $team->id }}/members" class="mt-4">
            @csrf
            <select name="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm mb-2">
                <option value="">Sélectionner un utilisateur</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="w-full bg-blue-700 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-800">
                <i class="fas fa-user-plus mr-1"></i>Ajouter
            </button>
        </form>
    </div>

    <!-- Projets -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Projets</h2>
        @forelse($team->projects as $project)
        <div class="py-2 border-b last:border-0">
            <a href="/projects/{{ $project->id }}" class="text-blue-700 hover:underline text-sm font-medium">
                {{ $project->name }}
            </a>
            <span class="text-xs text-gray-500 ml-2">{{ $project->status }}</span>
        </div>
        @empty
            <p class="text-gray-500 text-sm">Aucun projet</p>
        @endforelse

        <a href="/projects/create" class="mt-4 inline-block w-full text-center bg-green-50 text-green-700 px-3 py-2 rounded-lg hover:bg-green-100 text-sm">
            <i class="fas fa-plus mr-1"></i>Nouveau projet
        </a>
    </div>

</div>
@endsection