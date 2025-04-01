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

    public $timestamps = false; // porque tus campos ya se manejan manualmente

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserId');
    }
}


