@extends('layouts.app')

@section('title', 'Gestion des Équipes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-users-cog mr-2 text-blue-700"></i>Gestion des Équipes
    </h1>
    <div class="flex gap-2">
        <a href="/teams/create" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 text-sm">
            <i class="fas fa-plus mr-1"></i>Nouvelle équipe
        </a>
        <a href="/admin/dashboard" class="text-blue-700 hover:underline">
            <i class="fas fa-arrow-left mr-1"></i>Retour
        </a>
    </div>
</div>

@if($teams->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
        <p class="text-gray-500 text-lg">Aucune équipe pour le moment</p>
        <a href="/teams/create" class="mt-4 inline-block bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
            Créer une équipe
        </a>
    </div>
@else
    <div class="space-y-4">
        @foreach($teams as $team)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- En-tête équipe -->
            <div class="p-6 border-b cursor-pointer hover:bg-gray-50" onclick="toggleTeamDetails({{ $team->id }})">
                <div class="flex justify-between items-center">
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-chevron-right transition-transform" id="chevron-{{ $team->id }}"></i>
                            {{ $team->name }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $team->description ?? 'Aucune description' }}</p>
                    </div>
                    <div class="flex items-center gap-6 text-sm">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $team->members->count() }}</p>
                            <p class="text-xs text-gray-500">Membres</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $team->projects_count }}</p>
                            <p class="text-xs text-gray-500">Projets</p>
                        </div>
                        <div class="flex gap-2">
                            <form method="POST" action="/admin/teams/{{ $team->id }}" class="inline" onsubmit="return confirm('Supprimer cette équipe ? Cette action est irréversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails équipe (masqué par défaut) -->
            <div id="details-{{ $team->id }}" class="hidden border-t">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                    <!-- Informations -->
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-600"></i>
                            Informations
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-gray-500">Propriétaire</p>
                                <p class="font-medium text-gray-800">{{ $team->owner->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Créée le</p>
                                <p class="font-medium text-gray-800">{{ $team->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <a href="/teams/{{ $team->id }}/edit" class="mt-4 inline-block bg-yellow-50 text-yellow-700 px-4 py-2 rounded-lg hover:bg-yellow-100 text-sm">
                            <i class="fas fa-edit mr-1"></i>Modifier l'équipe
                        </a>
                    </div>

                    <!-- Membres -->
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-users text-blue-600"></i>
                            Mes Membres ({{ $team->members->count() }})
                        </h3>
                        <div class="space-y-2 mb-4 max-h-64 overflow-y-auto">
                            @forelse($team->members as $member)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-700 font-bold text-xs">{{ substr($member->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $member->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $member->email }}</p>
                                        </div>
                                    </div>
                                    @if($member->id !== $team->owner_id)
                                    <form method="POST" action="/admin/teams/{{ $team->id }}/members/{{ $member->id }}" class="inline" onsubmit="return confirm('Retirer ce membre ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-1 hover:bg-red-50 rounded transition">
                                            <i class="fas fa-user-minus text-sm"></i>
                                        </button>
                                    </form>
                                    @else
                                        <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">Propriétaire</span>
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Aucun membre</p>
                            @endforelse
                        </div>

                        <!-- Ajouter un membre -->
                        <form method="POST" action="/admin/teams/{{ $team->id }}/members" class="space-y-2 pt-4 border-t">
                            @csrf
                            <select name="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500" required>
                                <option value="">Ajouter un utilisateur</option>
                                @php
                                    $teamMemberIds = $team->members->pluck('id')->toArray();
                                    $availableUsers = \App\Models\User::whereNotIn('id', $teamMemberIds)->get();
                                @endphp
                                @forelse($availableUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->name }} ({{ $user->email }})</option>
                                @empty
                                    <option value="" disabled>Tous les utilisateurs sont dans cette équipe</option>
                                @endforelse
                            </select>
                            <button type="submit" class="w-full bg-blue-700 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-800 transition">
                                <i class="fas fa-user-plus mr-1"></i>Ajouter un utilisateur
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Projets -->
                <div class="px-6 py-4 border-t bg-gray-50">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-folder text-green-600"></i>
                        Projets ({{ $team->projects_count }})
                    </h3>
                    @if($team->projects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($team->projects as $project)
                                <a href="/projects/{{ $project->id }}" class="block p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-500 hover:shadow-sm transition">
                                    <p class="font-medium text-gray-800 text-sm">{{ $project->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $project->status }}</p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Aucun projet dans cette équipe</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

<script>
function toggleTeamDetails(teamId) {
    const details = document.getElementById('details-' + teamId);
    const chevron = document.getElementById('chevron-' + teamId);
    
    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        chevron.style.transform = 'rotate(90deg)';
    } else {
        details.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
    }
}
</script>
@endsection
