<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
/*use Illuminate\Contracts\Auth\MustVerifyEmail;*/
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/*class User extends Authenticatable implements MustVerifyEmail*/
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Valores permitidos para el campo rol
     */
    public const ROLES = [
        'admin' => 'Administrador',
        'cliente' => 'Cliente',
        'trabajador' => 'Trabajador'
    ];

    // 👇 Relaciones

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
