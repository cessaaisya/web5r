<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListFinding extends Model
{
    protected $fillable = [
        'daily_activity_id',
        'level',
        'countermeasure',
        'countermeasure_schedule',
        'progress',
        'image',
    ];

    protected $casts = [
        'countermeasure_schedule' => 'date',
    ];

    public function dailyActivity(): BelongsTo
    {
        return $this->belongsTo(DailyActivity::class);
    }
}
