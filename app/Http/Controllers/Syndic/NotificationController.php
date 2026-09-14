<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('syndic.notifications.index');
    }
}
