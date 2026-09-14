<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function __invoke(Request $request)
    {
        $announcements = Announcement::with('author')->pinnedFirst()->paginate(10);

        return view('resident.announcements.index', compact('announcements'));
    }
}
