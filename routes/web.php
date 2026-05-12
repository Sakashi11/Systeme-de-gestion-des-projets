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

    // Équipes
    Route::get('/teams',                [TeamWebController::class, 'index'])->name('teams.index');
    Route::get('/teams/create',         [TeamWebController::class, 'create'])->name('teams.create');
    Route::post('/teams',               [TeamWebController::class, 'store'])->name('teams.store');
    Route::get('/teams/{team}',         [TeamWebController::class, 'show'])->name('teams.show');
    Route::get('/teams/{team}/edit',    [TeamWebController::class, 'edit'])->name('teams.edit');
    Route::put('/teams/{team}',         [TeamWebController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{team}',      [TeamWebController::class, 'destroy'])->name('teams.destroy');

    // Projets
    Route::get('/projects',                 [ProjectWebController::class, 'index'])->name('projects.index');
    Route::get('/projects/create',          [ProjectWebController::class, 'create'])->name('projects.create');
    Route::post('/projects',                [ProjectWebController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}',       [ProjectWebController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit',  [ProjectWebController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}',       [ProjectWebController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}',    [ProjectWebController::class, 'destroy'])->name('projects.destroy');

    // Tâches
    Route::get('/tasks',                [TaskWebController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create',         [TaskWebController::class, 'create'])->name('tasks.create');
    Route::post('/tasks',               [TaskWebController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}',         [TaskWebController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit',    [TaskWebController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}',         [TaskWebController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}',      [TaskWebController::class, 'destroy'])->name('tasks.destroy');

    // Messages
    Route::get('/messages',             [MessageWebController::class, 'index'])->name('messages.index');
    Route::post('/messages',            [MessageWebController::class, 'store'])->name('messages.store');
});
// Routes Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard',          [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users',              [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{user}',    [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/teams',              [AdminController::class, 'teams'])->name('admin.teams');
    Route::delete('/teams/{team}',    [AdminController::class, 'deleteTeam'])->name('admin.teams.delete');
    Route::get('/projects',           [AdminController::class, 'projects'])->name('admin.projects');
    Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('admin.projects.delete');
    Route::get('/reports',            [AdminController::class, 'reports'])->name('admin.reports');
});
// Members
Route::get('/members',           [MemberController::class, 'index'])->name('admin.members.index');
Route::get('/members/create',    [MemberController::class, 'create'])->name('admin.members.create');
Route::post('/members',          [MemberController::class, 'store'])->name('admin.members.store');
Route::delete('/members/{user}', [MemberController::class, 'destroy'])->name('admin.members.destroy');