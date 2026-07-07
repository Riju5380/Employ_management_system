<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreakRecord extends Model
{
    // Explicitly set the table name because the model name is BreakRecord
    protected $table = 'breaks';

    protected $fillable = [
        'attendance_id',
        'break_start',
        'break_end',
        'duration_minutes',
    ];

    protected function casts(): array
    {
        return [
            'break_start' => 'datetime',
            'break_end' => 'datetime',
            'duration_minutes' => 'integer',
        ];
    }

    /*
     * RELATIONSHIPS
     */

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }
}
