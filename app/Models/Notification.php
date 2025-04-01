<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'Notifications';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'UserId',
        'Message',
        'IsRead',
        'CreatedAt',
        'UpdatedAt',
    ];
    
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

