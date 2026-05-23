<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50/50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion de Projets') - Project Manager</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        /* Custom scrollbar for premium feel */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full text-slate-800 antialiased flex">

    @auth
    <!-- Mobile Sidebar Toggle Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-white border-r border-slate-100 shadow-sm transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:flex">
        <!-- Logo Header -->
        <div class="flex h-20 items-center gap-3 px-6 border-b border-slate-50">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 shadow-md shadow-indigo-100 text-white">
                <i class="fas fa-project-diagram text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold bg-gradient-to-r from-slate-900 to-indigo-950 bg-clip-text text-transparent">ProjectManager</h1>
                <span class="text-[10px] font-semibold tracking-wider text-indigo-600 uppercase">Premium Workspace</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
            @php $role = Auth::user()->role; @endphp

            <!-- Espace Membre (Visible par tous les authentifiés) -->
            <div class="space-y-1.5">
                <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400">Mon Espace</span>
                
                @if(Auth::user()->isSuperAdmin())
                    <a href="/admin/dashboard" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('admin/dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas fa-chart-line text-base opacity-80"></i> Dashboard Admin
                    </a>
                @elseif(Auth::user()->isChefProjet())
                    <a href="/chef/dashboard" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('chef/dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas fa-chart-pie text-base opacity-80"></i> Dashboard Chef
                    </a>
                @else
                    <a href="/membre/dashboard" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('membre/dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas fa-dashboard text-base opacity-80"></i> Mon Dashboard
                    </a>
                    <a href="/membre/taches" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('membre/taches') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas fa-list-check text-base opacity-80"></i> Mes Tâches
                    </a>
                @endif

                <a href="/messages" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('messages*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-comments text-base opacity-80"></i> Discussions
                </a>
            </div>

            <!-- Espace Chef de Projet (Chef de projet & Super Admin) -->
            @if(Auth::user()->isChefProjet() || Auth::user()->isSuperAdmin())
            <div class="space-y-1.5 pt-4 border-t border-slate-100">
                <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400">Gestion Équipe</span>
                <a href="/chef/membres" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('chef/membres*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-users-viewfinder text-base opacity-80"></i> Mes Membres
                </a>
                <a href="/chef/taches" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('chef/taches*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-list-check text-base opacity-80"></i> Suivi des Tâches
                </a>
            </div>
            @endif

            <!-- Espace Administration Globale (Uniquement Super Admin) -->
            @if(Auth::user()->isSuperAdmin())
            <div class="space-y-1.5 pt-4 border-t border-slate-100">
                <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400">Administration</span>
                
                <a href="/admin/users" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('admin/users*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-users text-base opacity-80"></i> Utilisateurs
                </a>
                <a href="/teams" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('teams*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-people-group text-base opacity-80"></i> Équipes Système
                </a>
                <a href="/projects" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('projects*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-folder text-base opacity-80"></i> Projets Globaux
                </a>
                <a href="/admin/reports" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('admin/reports*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-chart-simple text-base opacity-80"></i> Rapports de Productivité
                </a>
            </div>
            @endif
        </div>

        <!-- User profile preview bottom -->
        <div class="border-t border-slate-100 p-4">
            <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition">
                <div class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white font-bold shadow-sm shadow-indigo-200">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="h-full w-full rounded-xl object-cover">
                    @else
                        {{ substr(Auth::user()->prenom ?? Auth::user()->name, 0, 1) }}{{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-semibold truncate text-slate-800">{{ Auth::user()->prenom }} {{ Auth::user()->name }}</p>
                    <span class="text-[10px] font-medium tracking-wide uppercase text-indigo-600">
                        @if(Auth::user()->isSuperAdmin())
                            Super Admin
                        @elseif(Auth::user()->isChefProjet())
                            Chef Projet
                        @else
                            Membre
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="mt-4 flex gap-2">
                <a href="/password/change" class="flex-1 text-center py-2 px-3 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold transition" title="Sécurité">
                    <i class="fas fa-key"></i>
                </a>
                <form action="/logout" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full text-center py-2 px-3 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-semibold transition" title="Se déconnecter">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>
    @endauth

    <!-- Main Workspace Container -->
    <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden">
        
        <!-- Header bar -->
        <header class="flex h-20 items-center justify-between px-6 md:px-8 bg-white/70 backdrop-blur-md border-b border-slate-100 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                @auth
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-slate-800 p-2 rounded-lg bg-slate-50">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                @endauth
                <div>
                    <h2 class="text-lg font-bold text-slate-800">@yield('title')</h2>
                </div>
            </div>

            <!-- Top right stats or notification -->
            <div class="flex items-center gap-4">
                <span class="text-xs text-slate-400 hidden md:inline-flex items-center gap-1.5 bg-slate-50 px-2.5 py-1 rounded-full border">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                    {{ now()->format('d/m/Y') }}
                </span>
                
                @auth
                <div class="h-8 w-px bg-slate-100 hidden sm:block"></div>
                <div class="hidden sm:flex items-center gap-2">
                    <span class="text-xs font-semibold px-2 py-1 rounded bg-indigo-50 text-indigo-700">
                        {{ Auth::user()->profession ?? 'Collaborateur' }}
                    </span>
                </div>
                @endauth
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto">
            
            <!-- Global Flash Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 flex items-center gap-3 shadow-sm shadow-emerald-50/50">
                    <div class="h-8 w-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="flex-1 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 flex items-center gap-3 shadow-sm shadow-rose-50/50">
                    <div class="h-8 w-8 rounded-lg bg-rose-500 text-white flex items-center justify-center shrink-0">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="flex-1 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-100 text-amber-800 flex items-center gap-3 shadow-sm shadow-amber-50/50">
                    <div class="h-8 w-8 rounded-lg bg-amber-500 text-white flex items-center justify-center shrink-0">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="flex-1 text-sm font-medium">
                        {{ session('warning') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Mobile Sidebar toggle helper -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>