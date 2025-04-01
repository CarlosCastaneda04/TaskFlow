<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'priority',
        'deadline',
        'created_at',
        'updated_at',
    ];

    // Relación con el proyecto
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Relación con el usuario asignado
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Relación con los comentarios
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
