<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Get counts with a single query each
        $counts = [
            'students' => User::where('role', 'student')->count(),
            'teachers' => User::where('role', 'teacher')->count(),
            'levels' => Level::count(),
            'subjects' => Subject::count(),
        ];

        // Get recent activity (last 5 items of each type)
        $recentActivity = User::where(function($query) {
                $query->where('role', 'student')
                      ->orWhere('role', 'teacher');
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(function($user) {
                return [
                    'type' => $user->role,
                    'name' => $user->full_name,
                    'date' => $user->created_at,
                    'icon' => $user->role === 'student' ? 'user-graduate' : 'chalkboard-teacher',
                    'color' => $user->role === 'student' ? 'primary' : 'success'
                ];
            });

        // Get level statistics
        $levelStats = Level::withCount(['students', 'subjects'])
            ->get()
            ->map(function($level) {
                return [
                    'name' => $level->name,
                    'students' => $level->students_count,
                    'subjects' => $level->subjects_count
                ];
            });

        return view('backend.dashboard.admin', compact('counts', 'recentActivity', 'levelStats'));
    }
}
