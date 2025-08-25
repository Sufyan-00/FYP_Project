<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentTemplateController extends Controller
{
    public function index()
    {
        $templates = DocumentTemplate::all();
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $request->file('document')->store('templates', 'public');

        DocumentTemplate::create([
            'name' => $request->name,
            'file_path' => $path,
        ]);

        return redirect()->route('admin.templates.index')->with('success', 'Template uploaded successfully.');
    }

    public function destroy(DocumentTemplate $template)
    {
        Storage::disk('public')->delete($template->file_path);
        $template->delete();
        return redirect()->route('admin.templates.index')->with('success', 'Template deleted successfully.');
    }
}