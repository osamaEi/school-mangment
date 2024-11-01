<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Mark;
use App\Models\SubjectFile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
    ];

    public function getPhotoUrlstudent()
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::url($this->photo);
        }
        return asset('images/student.png'); 
    }
    public function getPhotoUrlteacher()
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::url($this->photo);
        }
        return asset('images/teacher.png'); 
    }
    public function getStatusBadgeAttribute()
    {
        return $this->status 
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Inactive</span>';
    }
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name} ";
    }

    public function teachingSubjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject', 'teacher_id', 'subject_id')
                    ->withTimestamps();
    }

    public function taughtMarks()
    {
        return $this->hasMany(Mark::class, 'teacher_id');
    }

    // Student relationships
    public function enrolledLevels()
    {
        return $this->belongsToMany(Level::class, 'student_level', 'student_id', 'level_id')
                    ->withPivot('status', 'enrolled_at', 'completed_at')
                    ->withTimestamps();
    }

    public function studentLevels()
    {
        return $this->belongsToMany(Level::class, 'student_level', 'student_id')
                    ->withPivot(['status', 'enrolled_at', 'completed_at'])
                    ->withTimestamps();
    }
    public function marks()
    {
        return $this->hasMany(Mark::class, 'student_id');
    }
    
    public function studentMarks()
    {
        return $this->hasMany(Mark::class, 'student_id');
    }
    
    public function currentLevel()
    {
        return $this->studentLevels()
                    ->wherePivot('status', 'active')
                    ->latest()
                    ->first();
    }
    // File relationships
    public function uploadedFiles()
    {
        return $this->hasMany(SubjectFile::class, 'uploaded_by');
    }

    // Scopes for different roles
    public function scopeTeachers($query)
    {
        return $query->where('role', 'teacher');
    }

    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeManagers($query)
    {
        return $query->where('role', 'manager');
    }
}
