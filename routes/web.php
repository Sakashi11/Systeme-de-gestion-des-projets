<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\TeamWebController;
use App\Http\Controllers\Web\ProjectWebController;
use App\Http\Controllers\Web\TaskWebController;
use App\Http\Controllers\Web\MessageWebController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\MemberController;
use App\Http\Controllers\Web\PasswordController;
use App\Http\Controllers\Web\ChefProjetController;
use App\Http\Controllers\Web\MembreController;

// Redirection page d'accueil
Route::get('/', function () {
    return redirect('/login');
});

// Routes publiques
Route::get('/login',    [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');
Route::get('/register', [AuthWebController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthWebController::class, 'register'])->name('register.post');

// Routes protégées
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes Équipes → réservées à l'admin uniquement
    Route::middleware(['auth', 'super_admin'])->group(function () {
        Route::get('/teams',                          [TeamWebController::class, 'index'])->name('teams.index');
        Route::get('/teams/create',                   [TeamWebController::class, 'create'])->name('teams.create');
        Route::post('/teams',                         [TeamWebController::class, 'store'])->name('teams.store');
        Route::get('/teams/{team}',                   [TeamWebController::class, 'show'])->name('teams.show');
        Route::get('/teams/{team}/edit',              [TeamWebController::class, 'edit'])->name('teams.edit');
        Route::put('/teams/{team}',                   [TeamWebController::class, 'update'])->name('teams.update');
        Route::delete('/teams/{team}',                [TeamWebController::class, 'destroy'])->name('teams.destroy');
        Route::post('/teams/{team}/members',          [TeamWebController::class, 'addMember'])->name('teams.members.add');
        Route::delete('/teams/{team}/members/{user}', [TeamWebController::class, 'removeMember'])->name('teams.members.remove');
    });

    // Routes Projets → réservées à l'admin uniquement
    Route::middleware(['auth', 'super_admin'])->group(function () {
        Route::get('/projects',                [ProjectWebController::class, 'index'])->name('projects.index');
        Route::get('/projects/create',         [ProjectWebController::class, 'create'])->name('projects.create');
        Route::post('/projects',               [ProjectWebController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}',      [ProjectWebController::class, 'show'])->name('projects.show');
        Route::get('/projects/{project}/edit', [ProjectWebController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}',      [ProjectWebController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}',   [ProjectWebController::class, 'destroy'])->name('projects.destroy');
    });

    // Tâches
    Route::get('/tasks',                [TaskWebController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create',         [TaskWebController::class, 'create'])->name('tasks.create');
    Route::post('/tasks',               [TaskWebController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}',         [TaskWebController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit',    [TaskWebController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}',         [TaskWebController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}',      [TaskWebController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/status', [TaskWebController::class, 'updateStatus'])->name('tasks.updateStatus');

    // Messages
    Route::get('/messages',             [MessageWebController::class, 'index'])->name('messages.index');
    Route::post('/messages',            [MessageWebController::class, 'store'])->name('messages.store');
});
// Routes Admin
Route::middleware(['auth', 'super_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard',          [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users',              [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{user}',    [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/teams',              [AdminController::class, 'teams'])->name('admin.teams');
    Route::delete('/teams/{team}',    [AdminController::class, 'deleteTeam'])->name('admin.teams.delete');
    Route::get('/projects',           [AdminController::class, 'projects'])->name('admin.projects');
    Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('admin.projects.delete');
    Route::get('/reports',            [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/users/create',  [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users',        [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::post('/teams/{team}/members',          [TeamWebController::class, 'addMember'])->name('admin.teams.members.add');
    Route::delete('/teams/{team}/members/{user}', [TeamWebController::class, 'removeMember'])->name('admin.teams.members.remove');
});


// Changement de mot de passe
Route::middleware('auth')->group(function () {
    Route::get('/password/change',  [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/change', [PasswordController::class, 'change'])->name('password.change.post');
});

// Routes Chef de Projet
// Routes Chef de Projet
Route::middleware(['auth', 'chef_projet'])->prefix('chef')->group(function () {
    Route::get('/dashboard',              [ChefProjetController::class, 'dashboard'])->name('chef.dashboard');
    Route::get('/membres',                [ChefProjetController::class, 'membres'])->name('chef.membres');
    Route::get('/taches',                 [ChefProjetController::class, 'taches'])->name('chef.taches');
    Route::get('/taches/create',          [ChefProjetController::class, 'createTache'])->name('chef.taches.create');
    Route::post('/taches',                [ChefProjetController::class, 'storeTache'])->name('chef.taches.store');
    Route::patch('/taches/{task}',        [ChefProjetController::class, 'updateStatutTache'])->name('chef.taches.statut');
    Route::delete('/taches/{task}',       [ChefProjetController::class, 'deleteTache'])->name('chef.taches.delete');
});

// Routes Membre
Route::middleware(['auth'])->prefix('membre')->group(function () {
    Route::get('/dashboard',               [MembreController::class, 'dashboard'])->name('membre.dashboard');
    Route::get('/taches',                  [MembreController::class, 'mesTaches'])->name('membre.taches');
    Route::patch('/taches/{task}',         [MembreController::class, 'updateStatut'])->name('membre.taches.statut');
    Route::post('/taches/{task}/comments', [MembreController::class, 'addComment'])->name('membre.taches.comment');
});