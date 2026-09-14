<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Residence;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('author')->pinnedFirst()->paginate(10);

        return view('syndic.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'type' => ['required', 'in:info,urgent,event,maintenance'],
            'pinned' => ['nullable', 'boolean'],
        ]);

        $residence = Residence::first();

        Announcement::create([
            'residence_id' => $residence->id,
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'pinned' => $request->has('pinned'),
            'published_at' => now(),
        ]);

        return back()->with('success', 'Annonce publiée avec succès.');
    }
}
