<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'UserId',
        'Message',
        'ReadAt',
        'CreatedAt',
        'UpdatedAt',
    ];

    public $timestamps = false; // manejamos las fechas manualmente

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserId');
    }

    // Este método asegura que UpdatedAt se actualice al guardar
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->UpdatedAt = now();
        });
    }
}

