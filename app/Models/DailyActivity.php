<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailyActivity extends Model
{
    protected $fillable = [
        'zone',
        'pic_name',
        'date',
        'abnormality',
        'image',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function listFindings(): HasMany
    {
        return $this->hasMany(ListFinding::class);
    }
}
