<?php

namespace App\Models;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    protected $fillable = ['name', 'description'];

    protected $table ='levels';
    // Relationships
    public function subjects()
    {
        return $this->hasMany(Subject::class,'level_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_level', 'level_id', 'student_id')
                    ->withPivot('status', 'enrolled_at', 'completed_at')
                    ->withTimestamps();
    }

    public function activeStudents()
    {
        return $this->students()->wherePivot('status', 'active');
    }

    public function completedStudents()
    {
        return $this->students()->wherePivot('status', 'completed');
    }
}
