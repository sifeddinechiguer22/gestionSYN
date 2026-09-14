<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Residence;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->paginate(10);

        return view('syndic.documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:pv_ag,reglement,contrat,facture,bilan,autre'],
            'document_file' => ['required', 'file', 'mimes:pdf,doc,docx,jpg,png', 'max:10240'],
        ]);

        $residence = Residence::first();
        $path = $request->file('document_file')->store('documents', 'public');
        $size = round($request->file('document_file')->getSize() / 1024 / 1024, 2) . ' MB';

        Document::create([
            'residence_id' => $residence->id,
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'category' => $request->category,
            'file_path' => $path,
            'file_size' => $size,
            'is_public' => true,
        ]);

        return back()->with('success', 'Document téléversé avec succès.');
    }
}
