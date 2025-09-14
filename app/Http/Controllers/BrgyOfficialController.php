<?php

namespace App\Http\Controllers;

use App\Models\Official;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrgyOfficialController extends Controller
{
    // LIST: /brgyofficials  (name: brgyofficials.index)
    public function index()
    {
        $captain  = Official::with('feedbacks')->where('position', 'Barangay Captain')->first();
        $kagawads = Official::with('feedbacks')->where('position', 'Barangay Kagawad')->get();

        $officials = Official::with('feedbacks')->orderBy('position')->get();

        // Check if user is admin - if so, show admin view, otherwise show public view
        if (auth('admin')->check()) {
            return view('brgyofficials.index', compact('captain', 'kagawads', 'officials'));
        } else {
            return view('brgyofficials.public', compact('captain', 'kagawads', 'officials'));
        }
    }

    // SHOW CREATE FORM: /brgyofficials/create
    public function create()
    {
        return view('brgyofficials.create');
    }

    // STORE NEW
    public function store(Request $request)
    {
        $data = $request->validate([
            'fname'        => 'required|string|max:50',
            'middle_initial' => 'nullable|string|max:10',
            'lname'        => 'required|string|max:50',
            'position'     => 'required|string',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'description'  => 'nullable|string',
            'photo'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('officials', 'public');
        }

        Official::create($data);

        return redirect()->route('brgyofficials.index')->with('success', 'Official added successfully.');
    }

    public function show($id)
    {
        $official = Official::with('feedbacks')->findOrFail($id);
        return view('brgyofficials.show', compact('official'));
    }

   // SHOW EDIT FORM
    public function edit(Official $brgyofficial)
    {
        return view('brgyofficials.edit', ['official' => $brgyofficial]);
    }

    // UPDATE
    public function update(Request $request, Official $brgyofficial)
    {
        $data = $request->validate([
            'fname'        => 'required|string|max:50',
            'middle_initial' => 'nullable|string|max:10',
            'lname'        => 'required|string|max:50',
            'age'          => 'nullable|integer|min:18|max:100',
            'position'     => 'required|string',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'description'  => 'nullable|string',
            'photo'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($brgyofficial->photo) {
                Storage::disk('public')->delete($brgyofficial->photo);
            }
            $data['photo'] = $request->file('photo')->store('officials', 'public');
        }

        $brgyofficial->update($data);

        return redirect()->route('admin.brgyofficials.index')->with('success', 'Official updated successfully.');
    }

    // DELETE
    public function destroy(Official $brgyofficial)
    {
        if ($brgyofficial->photo) {
            Storage::disk('public')->delete($brgyofficial->photo);
        }

        $brgyofficial->delete();

        return redirect()->route('admin.brgyofficials.index')->with('success', 'Official deleted successfully.');
    }
}
