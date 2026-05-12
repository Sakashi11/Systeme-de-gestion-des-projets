<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    // Relations
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    // Calcul automatique de la progression
    public function getProgressAttribute()
    {
        $total = $this->tasks()->count();
        if ($total === 0) return 0;
        return round(($this->tasks()->where('status', 'done')->count() / $total) * 100);
    }
}