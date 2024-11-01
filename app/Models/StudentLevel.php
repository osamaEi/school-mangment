<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentLevel extends Pivot
{
    protected $table = 'student_level';

    protected $fillable = [
        'student_id',
        'level_id',
        'status',
        'enrolled_at',
        'completed_at'
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    // Custom methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function complete()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }
}