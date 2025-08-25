<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentTemplateController extends Controller
{
    public function index()
    {
        $templates = DocumentTemplate::latest()->get();
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB
        ]);

        $path = $request->file('document')->store('templates', 'public');

        DocumentTemplate::create([
            'name'      => $request->string('name'),
            'file_path' => $path,
        ]);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template uploaded successfully.');
    }

    // Allow authenticated users (students/supervisors/admin) to download templates
    public function download(DocumentTemplate $template)
    {
        $extension = pathinfo($template->file_path, PATHINFO_EXTENSION);
        $downloadAs = Str::slug($template->name) . ($extension ? '.' . $extension : '');

        return Storage::disk('public')->download($template->file_path, $downloadAs);
    }

    public function destroy(DocumentTemplate $template)
    {
        Storage::disk('public')->delete($template->file_path);
        $template->delete();

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template deleted successfully.');
    }
}