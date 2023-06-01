<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'start_time',
        'end_time',
        'pending',
    ];

    public function getTimeWorked(): string
    {
        $start = strtotime($this->start_time);
        $end = strtotime($this->end_time);

        $hours = floor(($end - $start) / 3600);
        $minutes = floor(($end - $start) / 60 % 60);

        return $hours . ':' . $minutes;
    }

    public function principal(): BelongsTo
    {
        return $this->belongsTo(Principal::class);
    }
}
