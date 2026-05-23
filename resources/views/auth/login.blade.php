@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl shadow-slate-100 border border-slate-100/80 relative overflow-hidden">
        
        <!-- Subtle Top Gradient Bar -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-600"></div>

        <!-- Logo / Header -->
        <div class="text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 shadow-lg shadow-indigo-100 text-white mb-6">
                <i class="fas fa-project-diagram text-2xl animate-pulse"></i>
            </div>
            <h2 class="text-3xl font-extrabold bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-950 bg-clip-text text-transparent">
                Project Manager
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Connectez-vous pour accéder à votre espace de travail
            </p>
        </div>

        <!-- Session & Error Alerts -->
        @if($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <p class="flex items-center gap-2 font-medium">
                        <i class="fas fa-exclamation-circle text-rose-500 shrink-0"></i>
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm flex items-center gap-2 font-medium">
                <i class="fas fa-check-circle text-emerald-500 shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire -->
        <form class="mt-8 space-y-6" method="POST" action="/login">
            @csrf

            <div class="space-y-4">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <i class="fas fa-envelope text-slate-400 text-xs"></i> Adresse Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        value="{{ old('email') }}"
                        required
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all text-sm"
                        placeholder="nom@exemple.com"
                    />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="block text-sm font-semibold text-slate-700 flex items-center gap-1.5">
                            <i class="fas fa-lock text-slate-400 text-xs"></i> Mot de passe / Code d'accès
                        </label>
                    </div>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-4 pr-12 py-3 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all text-sm"
                            placeholder="Saisissez votre code d'accès ou mot de passe"
                        />
                        <button
                            type="button"
                            onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 focus:outline-none"
                        >
                            <i id="password-toggle-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button
                    type="submit"
                    class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all shadow-md shadow-indigo-100"
                >
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-indigo-200 group-hover:text-white transition"></i>
                    </span>
                    Se connecter
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('password-toggle-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection