<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'total_hours',
        'notes',
        'work_summary',
        'work_document',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
            'check_in' => 'datetime',
            'check_out' => 'datetime',
            'total_hours' => 'decimal:2',
        ];
    }

    /*
     * HELPER METHODS
     */

    public function isCheckedIn(): bool
    {
        return !is_null($this->check_in) && is_null($this->check_out);
    }

    public function totalBreakMinutes(): int
    {
        return (int) $this->breaks()->sum('duration_minutes');
    }

    public function netWorkingMinutes(): int
    {
        $start = $this->check_in;
        if (!$start) {
            return 0;
        }

        $end = $this->check_out ?? Carbon::now();

        $totalMinutes = $start->diffInMinutes($end);
        $breakMinutes = $this->totalBreakMinutes();

        return max(0, $totalMinutes - $breakMinutes);
    }

    /*
     * RELATIONSHIPS
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function breaks(): HasMany
    {
        return $this->hasMany(BreakRecord::class);
    }

    public function workLogs(): HasMany
    {
        return $this->hasMany(WorkLog::class);
    }
}
