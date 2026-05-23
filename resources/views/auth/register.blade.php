@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl shadow-slate-100 border border-slate-100/80 relative overflow-hidden">
        
        <!-- Subtle Top Gradient Bar -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-600"></div>

        <!-- Logo / Header -->
        <div class="text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 shadow-lg shadow-indigo-100 text-white mb-6">
                <i class="fas fa-project-diagram text-2xl"></i>
            </div>
            <h2 class="text-3xl font-extrabold bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-950 bg-clip-text text-transparent">
                Créer un compte
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Rejoignez la plateforme collaborative de gestion de projets
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

        <!-- Formulaire -->
        <form class="mt-8 space-y-5" method="POST" action="/register">
            @csrf

            <div class="space-y-4">
                <!-- Nom complet -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <i class="fas fa-user text-slate-400 text-xs"></i> Nom complet
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all text-sm"
                        placeholder="Ex: John Doe"
                    />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <i class="fas fa-envelope text-slate-400 text-xs"></i> Adresse Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all text-sm"
                        placeholder="Ex: john.doe@exemple.com"
                    />
                </div>

                <!-- Profession -->
                <div>
                    <label for="profession" class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <i class="fas fa-briefcase text-slate-400 text-xs"></i> Profession (Optionnel)
                    </label>
                    <input
                        id="profession"
                        name="profession"
                        type="text"
                        value="{{ old('profession') }}"
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all text-sm"
                        placeholder="Ex: Développeur, Chef de Projet..."
                    />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <i class="fas fa-lock text-slate-400 text-xs"></i> Mot de passe
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all text-sm"
                        placeholder="Minimum 8 caractères"
                    />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <i class="fas fa-lock text-slate-400 text-xs"></i> Confirmer le mot de passe
                    </label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all text-sm"
                        placeholder="Confirmez votre mot de passe"
                    />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button
                    type="submit"
                    class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all shadow-md shadow-indigo-100"
                >
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-indigo-200 group-hover:text-white transition"></i>
                    </span>
                    Créer mon compte
                </button>
            </div>
        </form>

        <!-- Divider -->
        <div class="relative flex py-2 items-center">
            <div class="flex-grow border-t border-slate-100"></div>
            <span class="flex-shrink mx-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">Déjà inscrit ?</span>
            <div class="flex-grow border-t border-slate-100"></div>
        </div>

        <!-- Connexion link -->
        <div class="text-center">
            <a href="/login" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
                Se connecter à votre compte <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

    </div>
</div>
@endsection