<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrentSk; // Make sure your model exists
use Illuminate\Support\Facades\Storage;

class CurrentSKController extends Controller
{
    public function create()
    {
        return view('currentsk.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fname' => 'required|string|max:50',
            'middle_initial' => 'nullable|string|max:5',
            'lname' => 'required|string|max:50',
            'age' => 'required|integer',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:Male,Female',
            'birthdate' => 'nullable|date',
            'position' => 'required|string',
            'platform' => 'nullable|string',
            'credentials' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('sk_officials', 'public');
        }

        CurrentSk::create($data);

        return redirect()->route('admin.currentsk.index')->with('success', 'SK official added successfully.');
    }

    public function index()
    {
        // Adjust the "Chairperson" string to match exactly what is stored in DB
        $chairperson = CurrentSk::with('feedbacks')->where('position', 'Chairperson')->first();

        $members = CurrentSk::with('feedbacks')->where('position', '!=', 'Chairperson')->get();

        // Check if user is admin - if so, show admin view, otherwise show public view
        if (auth('admin')->check()) {
            return view('currentsk.index', compact('chairperson', 'members'));
        } else {
            return view('currentsk.public', compact('chairperson', 'members'));
        }
    }

    public function show(CurrentSk $currentsk)
    {
        $currentsk->load('feedbacks');
        return view('currentsk.show', compact('currentsk'));
    }

    public function edit(CurrentSk $currentsk)
    {
        return view('currentsk.edit', compact('currentsk'));
    }

    public function update(Request $request, CurrentSk $currentsk)
    {
        $data = $request->validate([
            'fname' => 'required|string|max:50',
            'middle_initial' => 'nullable|string|max:5',
            'lname' => 'required|string|max:50',
            'age' => 'required|integer',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:Male,Female',
            'birthdate' => 'nullable|date',
            'position' => 'required|string',
            'platform' => 'nullable|string',
            'credentials' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('photo')) {
            if ($currentsk->photo) {
                Storage::disk('public')->delete($currentsk->photo);
            }
            $data['photo'] = $request->file('photo')->store('sk_officials', 'public');
        }

        $currentsk->update($data);

        return redirect()->route('admin.currentsk.index')->with('success', 'SK official updated successfully.');
    }

    public function destroy(CurrentSk $currentsk)
    {
        if ($currentsk->photo) {
            Storage::disk('public')->delete($currentsk->photo);
        }

        $currentsk->delete();

        return redirect()->route('admin.currentsk.index')->with('success', 'SK official deleted successfully.');
    }
}
