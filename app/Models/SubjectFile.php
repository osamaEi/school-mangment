<?php

namespace App\Models;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubjectFile extends Model
{
    use HasFactory;

    protected $table ='subject_files';

    protected $fillable = [
        'title',
        'file_path',
        'subject_id',
        'uploaded_by'
    ];

    // Relationships
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    
   
    public function getFileUrl()
    {
        return Storage::url($this->file_path);
    }
}
