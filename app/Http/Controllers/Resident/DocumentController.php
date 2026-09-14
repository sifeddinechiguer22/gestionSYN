<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __invoke(Request $request)
    {
        $documents = Document::where('is_public', true)->latest()->paginate(10);

        return view('resident.documents.index', compact('documents'));
    }
}
