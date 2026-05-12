<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;

// Routes publiques
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login',    [AuthController::class, 'login']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout',          [AuthController::class, 'logout']);
    Route::get('/auth/profile',          [AuthController::class, 'profile']);
    Route::post('/auth/profile/update',  [AuthController::class, 'updateProfile']);

    // Teams
    Route::get('/teams',                          [TeamController::class, 'index']);
    Route::post('/teams',                         [TeamController::class, 'store']);
    Route::get('/teams/{team}',                   [TeamController::class, 'show']);
    Route::put('/teams/{team}',                   [TeamController::class, 'update']);
    Route::delete('/teams/{team}',                [TeamController::class, 'destroy']);
    Route::post('/teams/{team}/members',          [TeamController::class, 'addMember']);
    Route::delete('/teams/{team}/members/{user}', [TeamController::class, 'removeMember']);

    // Projects
    Route::get('/teams/{team}/projects',    [ProjectController::class, 'index']);
    Route::post('/teams/{team}/projects',   [ProjectController::class, 'store']);
    Route::get('/projects/{project}',       [ProjectController::class, 'show']);
    Route::put('/projects/{project}',       [ProjectController::class, 'update']);
    Route::delete('/projects/{project}',    [ProjectController::class, 'destroy']);

    // Tasks
    Route::get('/projects/{project}/tasks',  [TaskController::class, 'index']);
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{task}',              [TaskController::class, 'show']);
    Route::put('/tasks/{task}',              [TaskController::class, 'update']);
    Route::patch('/tasks/{task}/status',     [TaskController::class, 'updateStatus']);
    Route::delete('/tasks/{task}',           [TaskController::class, 'destroy']);

    // Messages
    Route::get('/teams/{team}/messages',  [MessageController::class, 'index']);
    Route::post('/teams/{team}/messages', [MessageController::class, 'store']);
    Route::delete('/messages/{message}',  [MessageController::class, 'destroy']);

    // Files
    Route::get('/projects/{project}/files',  [FileController::class, 'index']);
    Route::post('/projects/{project}/files', [FileController::class, 'store']);
    Route::delete('/files/{file}',           [FileController::class, 'destroy']);

    // Comments
    Route::get('/tasks/{task}/comments',  [CommentController::class, 'index']);
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}',  [CommentController::class, 'destroy']);

    // Reports
    Route::get('/teams/{team}/reports/productivity',   [ReportController::class, 'teamProductivity']);
    Route::get('/projects/{project}/reports/progress', [ReportController::class, 'projectProgress']);
});