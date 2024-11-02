<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = Level::with(['subjects'])->latest()->paginate(10);
        return view('backend.levels.index', compact('levels'));
    }

    public function create()
    {
        return view('backend.levels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:levels',
            'description' => 'nullable|string'
        ]);

        Level::create($validated);

        return redirect()->route('Adminlevel.index')
            ->with('success', 'Level created successfully.');
    }

public function show($id)
{
    $level = Level::with(['subjects', 'students'])->findOrFail($id);
    
    return view('backend.levels.show', compact('level'));
}

    public function edit(Level $level)
    {
        return view('backend.levels.edit', compact('level'));
    }

    public function update(Request $request, Level $level)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:levels,name,' . $level->id,
            'description' => 'nullable|string'
        ]);

        $level->update($validated);

        return redirect()->route('Adminlevel.index')
            ->with('success', 'Level updated successfully.');
    }

    public function destroy(Level $level)
    {
        $level->delete();
        return redirect()->route('Adminlevel.index')
            ->with('success', 'Level deleted successfully.');
    }
}
