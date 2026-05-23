@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-envelope mr-2 text-blue-700"></i>Messagerie
    </h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    <!-- Liste des équipes -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-sm font-semibold text-gray-700 mb-3">Mes équipes</h2>
        <a href="/messages"
           class="block px-3 py-2 rounded-lg mb-3 text-sm {{ !$selectedTeam ? 'bg-blue-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-globe mr-2"></i>Tous les messages
        </a>
        @forelse($teams as $team)
            <a href="/messages?team={{ $team->id }}"
               class="block px-3 py-2 rounded-lg mb-1 text-sm
               {{ $selectedTeam && $selectedTeam->id == $team->id ? 'bg-blue-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-users mr-2"></i>{{ $team->name }}
                <span class="ml-2 px-2 py-0.5 rounded-full bg-slate-100 text-xs text-slate-500">{{ $team->messages_count }}</span>
            </a>
        @empty
            <p class="text-gray-500 text-sm">Aucune équipe</p>
        @endforelse
    </div>

    <!-- Messages -->
    <div class="md:col-span-3 bg-white rounded-lg shadow flex flex-col" style="height: 600px;">

        @if($selectedTeam)
            <!-- Header -->
            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold text-gray-800">
                    <i class="fas fa-users mr-2 text-blue-700"></i>{{ $selectedTeam->name }}
                </h2>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4" id="messages-container">
                @forelse($messages as $message)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-700 font-bold text-sm">
                                {{ substr($message->sender->name, 0, 1) }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <span class="font-medium text-sm text-gray-800">{{ $message->sender->name }}</span>
                                <span class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                                <span class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-500">
                                    {{ $message->team->name }}
                                </span>
                            </div>
                            <div class="bg-gray-50 rounded-lg px-4 py-2 text-sm text-gray-700">
                                {{ $message->content }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400 text-sm">Aucun message. Soyez le premier à écrire !</p>
                @endforelse
            </div>

            <!-- Formulaire -->
            <div class="px-6 py-4 border-t">
                <form method="POST" action="/messages" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <select name="team_id" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 text-sm">
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ $selectedTeam && $selectedTeam->id == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full md:w-auto bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
                            <i class="fas fa-paper-plane"></i> Envoyer
                        </button>
                    </div>
                    <input
                        type="text"
                        name="content"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 text-sm"
                        placeholder="Écrire un message..."
                        required
                    />
                </form>
            </div>

        @else
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-comments text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500">Sélectionnez une équipe pour voir les messages</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-scroll vers le bas
    const container = document.getElementById('messages-container');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
</script>
@endsection