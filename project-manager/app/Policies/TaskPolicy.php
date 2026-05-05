<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    // Voir une tâche → membres de l'équipe du projet
    public function view(User $user, Task $task): bool
    {
        return $task->project->team->members()
                    ->where('user_id', $user->id)
                    ->exists();
    }

    // Modifier une tâche → créateur ou assigné ou admin
    public function update(User $user, Task $task): bool
    {
        if ($task->created_by === $user->id) return true;
        if ($task->assigned_to === $user->id) return true;

        return $task->project->team->members()
                    ->where('user_id', $user->id)
                    ->wherePivot('role', 'admin')
                    ->exists();
    }

    // Supprimer une tâche → créateur ou admin
    public function delete(User $user, Task $task): bool
    {
        if ($task->created_by === $user->id) return true;

        return $task->project->team->members()
                    ->where('user_id', $user->id)
                    ->wherePivot('role', 'admin')
                    ->exists();
    }
}