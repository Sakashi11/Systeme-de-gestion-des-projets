@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-users mr-2 text-blue-700"></i>Gestion des Utilisateurs
    </h1>
    <a href="/admin/dashboard" class="text-blue-700 hover:underline">
        <i class="fas fa-arrow-left mr-1"></i>Retour
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Profession</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâches</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Inscrit le</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-blue-700 font-bold text-sm">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <span class="font-medium text-gray-800">{{ $user->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->profession ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->tasks_count }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    <form method="POST" action="/admin/users/{{ $user->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Supprimer cet utilisateur ?')"
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