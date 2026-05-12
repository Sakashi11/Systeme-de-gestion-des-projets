@extends('layouts.app')

@section('title', 'Gestion des Équipes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-users-cog mr-2 text-blue-700"></i>Gestion des Équipes
    </h1>
    <a href="/admin/dashboard" class="text-blue-700 hover:underline">
        <i class="fas fa-arrow-left mr-1"></i>Retour
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipe</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Propriétaire</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Membres</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projets</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Créée le</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($teams as $team)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-800">{{ $team->name }}</p>
                    <p class="text-xs text-gray-500">{{ $team->description ?? '-' }}</p>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $team->owner->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $team->members->count() }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $team->projects_count }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $team->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    <form method="POST" action="/admin/teams/{{ $team->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Supprimer cette équipe ?')"
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