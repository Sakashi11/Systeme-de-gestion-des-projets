<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    // Voir une équipe → uniquement les membres
    public function view(User $user, Team $team): bool
    {
        return $team->members()->where('user_id', $user->id)->exists();
    }

    // Modifier une équipe → uniquement le propriétaire ou admin
    public function update(User $user, Team $team): bool
    {
        if ($team->owner_id === $user->id) return true;

        return $team->members()
                    ->where('user_id', $user->id)
                    ->wherePivot('role', 'admin')
                    ->exists();
    }

    // Supprimer une équipe → uniquement le propriétaire
    public function delete(User $user, Team $team): bool
    {
        return $team->owner_id === $user->id;
    }
}