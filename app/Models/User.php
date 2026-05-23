<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'prenom',
        'date_naissance',
        'code',
        'email',
        'password',
        'avatar',
        'profession',
        'role',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'password'             => 'hashed',
            'must_change_password' => 'boolean',
            'date_naissance'       => 'date',
        ];
    }

    // Helper roles
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isChefProjet(): bool
    {
        return $this->role === 'chef_projet';
    }

    public function isMembre(): bool
    {
        return $this->role === 'membre';
    }

    // Relations
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_members')
                    ->withPivot('role', 'joined_at');
    }

    public function ownedTeams()
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}