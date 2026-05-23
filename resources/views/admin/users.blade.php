@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-users mr-2 text-indigo-600"></i>Gestion des Utilisateurs
    </h1>
    <div class="flex gap-3">
        <a href="/admin/users/create" class="bg-indigo-600 text-white px-4 py-2.5 rounded-xl hover:bg-indigo-700 text-sm font-semibold shadow-sm transition">
            <i class="fas fa-user-plus mr-2"></i>Nouvel Utilisateur
        </a>
        <a href="/admin/dashboard" class="bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-xl hover:bg-slate-50 text-sm font-semibold transition">
            <i class="fas fa-arrow-left mr-1"></i>Retour
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left text-sm text-slate-500">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                <tr>
                    <th scope="col" class="px-6 py-4">Utilisateur</th>
                    <th scope="col" class="px-6 py-4">Email</th>
                    <th scope="col" class="px-6 py-4">Profession</th>
                    <th scope="col" class="px-6 py-4">Équipes</th>
                    <th scope="col" class="px-6 py-4">Tâches</th>
                    <th scope="col" class="px-6 py-4">Statut</th>
                    <th scope="col" class="px-6 py-4">Inscrit le</th>
                    <th scope="col" class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white font-bold shadow-sm shadow-indigo-100">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="h-full w-full rounded-xl object-cover">
                                @else
                                    {{ substr($user->prenom ?? $user->name, 0, 1) }}{{ substr($user->name, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $user->prenom }} {{ $user->name }}</p>
                                <span class="text-[10px] font-semibold uppercase tracking-wider
                                    @if($user->isSuperAdmin()) text-red-600
                                    @elseif($user->isChefProjet()) text-amber-600
                                    @else text-indigo-600 @endif">
                                    @if($user->isSuperAdmin())
                                        Super Admin
                                    @elseif($user->isChefProjet())
                                        Chef Projet
                                    @else
                                        Membre
                                    @endif
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600 font-medium">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $user->profession ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @forelse($user->teams as $team)
                                <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-md text-[11px] font-medium border border-indigo-100/50">
                                    {{ $team->name }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-400 font-normal">Aucune équipe</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700">
                            <i class="fas fa-list-check text-slate-400"></i>
                            {{ $user->tasks_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->must_change_password)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Nouveau / Doit changer MDP
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Actif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-400 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        @if($user->id !== Auth::id())
                        <form method="POST" action="/admin/users/{{ $user->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')"
                                class="text-rose-600 hover:text-rose-800 text-sm font-semibold inline-flex items-center gap-1 hover:bg-rose-50 px-2.5 py-1.5 rounded-lg transition">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-slate-400 italic">Vous-même</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection