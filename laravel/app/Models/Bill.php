<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Principal $principal
 * @property User $user
 */
class Bill extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'hours',
        'rate',
        'amount',
        'date',
        'description',
        'user_id',
        'principal_id',
        'url_token',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function principal(): BelongsTo
    {
        return $this->belongsTo(Principal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
