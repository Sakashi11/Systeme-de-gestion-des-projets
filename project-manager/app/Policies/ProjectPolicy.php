<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    // Voir un projet → membres de l'équipe
    public function view(User $user, Project $project): bool
    {
        return $project->team->members()->where('user_id', $user->id)->exists();
    }

    // Modifier un projet → admin ou propriétaire de l'équipe
    public function update(User $user, Project $project): bool
    {
        $team = $project->team;

        if ($team->owner_id === $user->id) return true;

        return $team->members()
                    ->where('user_id', $user->id)
                    ->wherePivot('role', 'admin')
                    ->exists();
    }

    // Supprimer un projet → admin ou propriétaire de l'équipe
    public function delete(User $user, Project $project): bool
    {
        return $this->update($user, $project);
    }
}