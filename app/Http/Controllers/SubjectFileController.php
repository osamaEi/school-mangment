<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubjectFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request, Subject $subject)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
            'subject_id' =>'required|exists:subjects,id'
        ]);

        $path = $request->file('file')->store('subject-files', 'public');

        SubjectFile::create([
            'title' => $request->title,
            'file_path' => $path,
            'uploaded_by' => auth()->id(),
            'subject_id' =>$request->subject_id,
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    public function destroy(SubjectFile $file)
    {
        Storage::disk('public')->delete($file->file_path);
        $file->delete();
        return back()->with('success', 'File deleted successfully.');
    }
}
