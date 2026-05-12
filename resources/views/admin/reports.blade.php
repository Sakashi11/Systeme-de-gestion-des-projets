@extends('layouts.app')

@section('title', 'Rapports')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-chart-bar mr-2 text-blue-700"></i>Rapports de Productivité
    </h1>
    <a href="/admin/dashboard" class="text-blue-700 hover:underline">
        <i class="fas fa-arrow-left mr-1"></i>Retour
    </a>
</div>

<div class="grid grid-cols-1 gap-6">
    @foreach($reports as $report)
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-users mr-2 text-blue-700"></i>{{ $report['team'] }}
            </h2>
            <span class="text-2xl font-bold
                @if($report['productivity'] >= 75) text-green-600
                @elseif($report['productivity'] >= 50) text-yellow-600
                @else text-red-600 @endif">
                {{ $report['productivity'] }}%
            </span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-4">
            <div class="text-center bg-gray-50 rounded-lg p-3">
                <p class="text-xl font-bold text-blue-600">{{ $report['members'] }}</p>
                <p class="text-xs text-gray-500">Membres</p>
            </div>
            <div class="text-center bg-gray-50 rounded-lg p-3">
                <p class="text-xl font-bold text-purple-600">{{ $report['projects'] }}</p>
                <p class="text-xs text-gray-500">Projets</p>
            </div>
            <div class="text-center bg-gray-50 rounded-lg p-3">
                <p class="text-xl font-bold text-gray-600">{{ $report['total_tasks'] }}</p>
                <p class="text-xs text-gray-500">Total tâches</p>
            </div>
            <div class="text-center bg-gray-50 rounded-lg p-3">
                <p class="text-xl font-bold text-green-600">{{ $report['done'] }}</p>
                <p class="text-xs text-gray-500">Terminées</p>
            </div>
            <div class="text-center bg-gray-50 rounded-lg p-3">
                <p class="text-xl font-bold text-yellow-600">{{ $report['in_progress'] }}</p>
                <p class="text-xs text-gray-500">En cours</p>
            </div>
        </div>

        <!-- Barre de progression -->
        <div>
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Productivité globale</span>
                <span>{{ $report['productivity'] }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="h-4 rounded-full
                    @if($report['productivity'] >= 75) bg-green-500
                    @elseif($report['productivity'] >= 50) bg-yellow-500
                    @else bg-red-500 @endif"
                    style="width: {{ $report['productivity'] }}%">
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection