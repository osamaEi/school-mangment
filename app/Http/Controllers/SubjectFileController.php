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
            'title' => 'nullable',
            'file' => 'required',
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
    public function download(SubjectFile $file)
    {
        if (!Storage::disk('public')->exists($file->file_path)) {
            return back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download($file->file_path, $file->title);
    }

    public function destroy(SubjectFile $file)
    {
        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }

            // Delete record from database
            $file->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }
}
