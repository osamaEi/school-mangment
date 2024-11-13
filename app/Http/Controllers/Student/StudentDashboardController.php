<?php

namespace App\Http\Controllers\Student;

use App\Models\SubjectFile;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDashboardController extends Controller
{
    public function index(){
        $student = Auth::user();
    
        $currentLevel = $student->currentLevel();
        
        $data = [
            'currentLevel' => $currentLevel,
            'averageScore' => $student->studentMarks()->avg('score') ?? 0,
            'totalSubjects' => $currentLevel ? $currentLevel->subjects->count() : 0,
            'recentMarks' => $student->studentMarks()
                ->with(['subject', 'teacher'])
                ->latest()
                ->take(5)
                ->get(),
            'currentSubjects' => $currentLevel ? $currentLevel->subjects()
                ->with(['teachers']) // Changed from 'teacher' to 'teachers'
                ->withLastMarkForStudent($student->id)
                ->get() : collect(),
                'subjectFiles' => $currentLevel ? SubjectFile::whereIn('subject_id', $currentLevel->subjects->pluck('id'))
                ->with(['subject', 'uploader'])
                ->latest()
                ->get() : collect(),
        ];

   
    
        return view('student.dashboard.index', $data);
    }


    public function downloadFile(SubjectFile $file)
    {
        // Check if student has access to this file
        $student = Auth::user();
        $currentLevel = $student->currentLevel();
        
        if (!$currentLevel || !$currentLevel->subjects->contains($file->subject_id)) {
            return back()->with('error', 'You do not have access to this file.');
        }

        if (!Storage::disk('public')->exists($file->file_path)) {
            return back()->with('error', 'File not found.');
        }

        // Get original file extension
        $extension = pathinfo($file->file_path, PATHINFO_EXTENSION);
        $fileName = $this->slugify($file->title) . '.' . $extension;

        return Storage::disk('public')->download(
            $file->file_path, 
            $fileName
        );
    }

    // Helper function to create safe filenames
    private function slugify($text)
    {
        // Replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // Transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // Trim
        $text = trim($text, '-');
        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // Lowercase
        $text = strtolower($text);
        return $text;
    }



    public function createPdf() {

        Pdf::view('pdf.invoice', ['invoice' => $invoice])
        ->save('/some/directory/invoice.pdf');

    }
    }

