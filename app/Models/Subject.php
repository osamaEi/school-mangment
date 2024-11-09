<?php

namespace App\Models;

use App\Models\Mark;
use App\Models\User;
use App\Models\Level;
use App\Models\SubjectFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{

    protected $table ='subjects';
    protected $fillable = ['name', 'description', 'level_id'];

    // Relationships
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_subject', 'subject_id', 'teacher_id')
                    ->withTimestamps();
    }

    public function files()
    {
        return $this->hasMany(SubjectFile::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    // Get all students through level
    public function students()
    {
        return $this->level->students();
    }
    public function scopeWithLastMarkForStudent($query, $studentId)
    {
        return $query->addSelect([
            'latest_mark' => Mark::select('score')
                ->whereColumn('subject_id', 'subjects.id')
                ->where('student_id', $studentId)
                ->latest()
                ->limit(1)
        ]);
    }
}
