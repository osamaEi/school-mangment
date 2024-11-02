<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'level_id' => 'required|exists:levels,id', // Ensures level_id exists in the levels table
        ]);
    
        // Create a new subject associated with the level
        Subject::create([
            'name' => $request->name,
            'description' => $request->description,
            'level_id' => $request->level_id,
        ]);
    
        return redirect()->back()
                         ->with('success', 'Subject added successfully');
    }
    

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $subject->update($validated);

        return back()->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return back()->with('success', 'Subject deleted successfully.');
    }
}
