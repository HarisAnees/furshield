<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $activities = AuditLog::with('user')->latest()->paginate(20);
        $totalUsers = User::count();

        return view('admin.notifications.index', compact('activities', 'totalUsers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target_audience' => 'required|in:all,owners,vets,shelters',
        ]);

        AuditLog::create([
            'action' => 'Broadcast Notification: ' . $validated['title'],
            'user_id' => auth()->id(),
            'subject_type' => 'Broadcast',
            'metadata' => ['target' => $validated['target_audience'], 'message' => $validated['message']],
        ]);

        return back()->with('success', "Notification broadcast sent to {$validated['target_audience']}.");
    }
}
