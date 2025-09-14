<?php

namespace App\Http\Controllers;

use App\Models\RunningOfficial;
use App\Models\Official;
use Illuminate\Http\Request;

class RunningOfficialController extends Controller
{
    // Display all running officials
    public function index()
    {
        $isAdmin = auth('admin')->check();

        $with = $isAdmin ? 'feedbacks' : ['feedbacks' => function ($query) {
            $query->where('verified', true);
        }];

        $captains = RunningOfficial::with($with)
            ->where('position', 'Barangay Captain')
            ->get();

        $kagawads = RunningOfficial::with($with)
            ->where('position', 'Kagawad')
            ->get();

        if ($isAdmin) {
            return view('runningofficials.index', compact('captains', 'kagawads'));
        } else {
            return view('runningofficials.public', compact('captains', 'kagawads'));
        }
    }

    // Show single official
    public function show($id)
    {
        $official = RunningOfficial::with('feedbacks')->findOrFail($id);
        return view('runningofficials.show', compact('official'));
    }

    // Show form to create a new official
    public function create()
    {
        return view('runningofficials.create');
    }

    // Store new official in database
    public function store(Request $request)
    {
        $data = $request->validate([
            'fname' => 'required|string|max:50',
            'middle_initial' => 'nullable|string|max:10',
            'lname' => 'required|string|max:50',
            'position' => 'required|string',
            'age' => 'required|integer|min:18|max:100',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:Male,Female',
            'birthdate' => 'nullable|date',
            'platforms' => 'nullable|array',
            'platforms.*' => 'nullable|string',
            'credentials' => 'nullable|array',
            'credentials.*' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Process platforms and credentials arrays
        $data['platform'] = isset($data['platforms'])
            ? array_values(array_filter($data['platforms'], fn($v) => !empty(trim($v))))
            : [];

        $data['credentials'] = isset($data['credentials'])
            ? array_values(array_filter($data['credentials'], fn($v) => !empty(trim($v))))
            : [];

        unset($data['platforms'], $data['credentials']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('official_photos', 'public');
        }

        RunningOfficial::create($data);

        return redirect()->route('admin.runningofficials.index')->with('success', 'Official added successfully.');
    }

    // Show form to edit an existing official
    public function edit($id)
    {
        $official = RunningOfficial::findOrFail($id);
        return view('runningofficials.edit', compact('official'));
    }

    // Update official in database
    public function update(Request $request, $id)
    {
        $official = RunningOfficial::findOrFail($id);

        $data = $request->validate([
            'fname' => 'required|string|max:50',
            'middle_initial' => 'nullable|string|max:10',
            'lname' => 'required|string|max:50',
            'position' => 'required|string',
            'age' => 'integer|min:18|max:100',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:Male,Female',
            'birthdate' => 'nullable|date',
            'platforms' => 'nullable|array',
            'platforms.*' => 'nullable|string',
            'credentials' => 'nullable|array',
            'credentials.*' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Process platforms and credentials arrays
        $data['platform'] = isset($data['platforms'])
            ? array_values(array_filter($data['platforms'], fn($v) => !empty(trim($v))))
            : [];

        $data['credentials'] = isset($data['credentials'])
            ? array_values(array_filter($data['credentials'], fn($v) => !empty(trim($v))))
            : [];

        unset($data['platforms'], $data['credentials']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('official_photos', 'public');
        }

        $official->update($data);

        return redirect()->route('admin.runningofficials.index')->with('success', 'Official updated successfully.');
    }

    // Delete an official
    public function destroy($id)
    {
        $official = RunningOfficial::findOrFail($id);
        $official->delete();

        return redirect()->route('admin.runningofficials.index')->with('success', 'Official deleted successfully.');
    }

    // Mark running official as election winner and promote to current official
    public function markAsWinner($id)
    {
        $runningOfficial = RunningOfficial::findOrFail($id);

        $existingOfficial = Official::where('position', $runningOfficial->position)->first();
        if ($existingOfficial) {
            $existingOfficial->delete();
        }

        Official::create([
            'fname' => $runningOfficial->fname,
            'middle_initial' => $runningOfficial->middle_initial,
            'lname' => $runningOfficial->lname,
            'age' => $runningOfficial->age,
            'gender' => $runningOfficial->gender,
            'birthdate' => $runningOfficial->birthdate,
            'position' => $runningOfficial->position,
            'phone' => $runningOfficial->phone,
            'email' => $runningOfficial->email,
            'description' => $runningOfficial->platform,
            'photo' => $runningOfficial->photo,
            'platform' => $runningOfficial->platform,
            'credentials' => $runningOfficial->credentials,
        ]);

        $runningOfficial->delete();

        return redirect()->route('admin.runningofficials.index')->with('success', 'Official marked as winner and promoted to current officials! Previous official has been replaced.');
    }
}
