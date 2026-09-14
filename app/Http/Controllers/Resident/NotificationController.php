<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('resident.notifications.index');
    }
}
