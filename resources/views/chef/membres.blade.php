@extends('layouts.app')

@section('title', 'Mes Membres')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-users mr-2 text-blue-700"></i>Mes Membres
    </h1>
    <a href="/chef/membres/create" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
        <i class="fas fa-user-plus mr-2"></i>Nouveau Membre
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Membre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Profession</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipe</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($membres as $membre)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-blue-700 font-bold text-sm">{{ substr($membre->name, 0, 1) }}</span>
                        </div>
                        <span class="font-medium text-gray-800">{{ $membre->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $membre->email }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $membre->profession ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    @foreach($membre->teams as $team)
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs mr-1">
                            {{ $team->name }}
                        </span>
                    @endforeach
                </td>
                <td class="px-6 py-4">
                    @if($membre->must_change_password)
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">
                            Doit changer mdp
                        </span>
                    @else
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                            Actif
                        </span>
                    @endif
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Aucun membre pour le moment
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection