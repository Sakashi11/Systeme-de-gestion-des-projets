<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Manager - @yield('title')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @yield('styles')
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    @auth
    <nav class="bg-blue-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="
                @if(auth()->user()->isSuperAdmin()) /admin/dashboard
                @elseif(auth()->user()->isChefProjet()) /chef/dashboard
                @else /membre/dashboard
                @endif
            " class="text-xl font-bold">
                <i class="fas fa-project-diagram mr-2"></i>Project Manager
            </a>

        <div class="flex items-center gap-6">

            {{-- Super Admin --}}
            @if(auth()->user()->isSuperAdmin())
                <a href="/admin/dashboard" class="hover:text-blue-200">
                    <i class="fas fa-shield-alt mr-1"></i>Dashboard
                </a>
                <a href="/admin/users" class="hover:text-blue-200">
                    <i class="fas fa-users mr-1"></i>Utilisateurs
                </a>
                <a href="/admin/teams" class="hover:text-blue-200">
                    <i class="fas fa-users-cog mr-1"></i>Équipes
                </a>
                <a href="/admin/projects" class="hover:text-blue-200">
                    <i class="fas fa-folder mr-1"></i>Projets
                </a>
                <a href="/admin/reports" class="hover:text-blue-200">
                    <i class="fas fa-chart-bar mr-1"></i>Rapports
                </a>

            {{-- Chef de Projet --}}
            @elseif(auth()->user()->isChefProjet())
                <a href="/chef/dashboard" class="hover:text-blue-200">
                    <i class="fas fa-home mr-1"></i>Dashboard
                </a>
                <a href="/chef/membres" class="hover:text-blue-200">
                    <i class="fas fa-users mr-1"></i>Mon Équipe
                </a>
                <a href="/tasks" class="hover:text-blue-200">
                    <i class="fas fa-tasks mr-1"></i>Tâches
                </a>
                <a href="/messages" class="hover:text-blue-200">
                    <i class="fas fa-envelope mr-1"></i>Messages
                </a>

            {{-- Membre --}}
            @else
                <a href="/membre/dashboard" class="hover:text-blue-200">
                    <i class="fas fa-home mr-1"></i>Dashboard
                </a>
                <a href="/membre/taches" class="hover:text-blue-200">
                    <i class="fas fa-tasks mr-1"></i>Mes Tâches
                </a>
                <a href="/messages" class="hover:text-blue-200">
                    <i class="fas fa-envelope mr-1"></i>Messages
                </a>
            @endif

            {{-- Déconnexion --}}
            <form method="POST" action="/logout" class="inline">
                @csrf
                <button type="submit" class="hover:text-blue-200">
                    <i class="fas fa-sign-out-alt mr-1"></i>Déconnexion
                </button>
            </form>
        </div>
    </div>
</nav>
@endauth

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>