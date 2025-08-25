<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;  

class UserController extends Controller
{
     public function index()
    {
        // Fetch all users, newest first, and paginate the results
        $users = User::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:student,supervisor,admin'],
        ]);

        $user->update([
            'name' => $request->name,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully!');
    }
    public function toggleStatus(Request $request, User $user)
    {
        // Prevent admin from deactivating themselves
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'You cannot deactivate your own account.']);
        }

        $newStatus = $user->status === 'active' ? 'deactivated' : 'active';
        $user->update(['status' => $newStatus]);

        $message = "User has been successfully " . ($newStatus === 'active' ? 'reactivated' : 'deactivated') . ".";

        return redirect()->route('admin.users.index')->with('status', $message);
    }


     public function showUploadForm()
    {
        return view('admin.users.upload');
    }

    /**
     * Process the uploaded CSV file to create users.
     */
    public function processUpload(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $path = $request->file('csv_file')->getRealPath();
    $file = fopen($path, 'r');

    // Skip the header row
    $header = fgetcsv($file);

    $createdCount = 0;
    $errors = [];

    while (($row = fgetcsv($file)) !== false) {
        // Combine header and row to create an associative array
        $data = array_combine($header, $row);

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => ['required', 'string', Rule::in(['student', 'supervisor'])],
        ]);

        if ($validator->fails()) {
            $errors[] = "Invalid data for email {$data['email']}: " . $validator->errors()->first();
            continue;
        }

        // --- Start of Change ---

        // Step 1: Create the user and store it in a variable
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make('password'), // Assign a default password
            'email_verified_at' => now(), // Pre-verify the email
        ]);

        // Step 2: NEW - If the created user is a supervisor, also create their profile
        if ($user->role === 'supervisor') {
            $user->supervisorProfile()->create([
                'available_slots' => 8, // The default of 8 slots is now assigned here
                'research_interests' => 'Please update your profile.', // A default placeholder
            ]);
        }

        // --- End of Change ---

        $createdCount++;
    }

    fclose($file);

    if (count($errors) > 0) {
        return redirect()->route('admin.users.upload.form')
            ->with('error', "Process finished with errors. Created {$createdCount} users. Errors: " . implode('; ', $errors));
    }

    return redirect()->route('admin.users.index')
        ->with('success', "Successfully created {$createdCount} new users.");
}
    public function downloadTemplate()
    {
        $filename = "user_import_template.csv";
        
        // These headers will force the browser to download the file
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // The callback function generates the CSV content line by line
        $callback = function() {
            // 'php://output' is a write-only stream that allows you to write to the response body
            $file = fopen('php://output', 'w');
            
            // 1. Add the header row
            fputcsv($file, ['name', 'email', 'role']);
            
            // 2. Add some example data to guide the user
            fputcsv($file, ['Sample Student', 'student@example.com', 'student']);
            fputcsv($file, ['Sample Supervisor', 'supervisor@example.com', 'supervisor']);
            
            fclose($file);
        };

        // Stream the response to the browser
        return response()->stream($callback, 200, $headers);
    }
}
