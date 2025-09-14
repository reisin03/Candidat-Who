<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RunningSk;
use App\Models\CurrentSK;
use Illuminate\Support\Facades\Storage;

class RunningSKController extends Controller
{
    // Display all running SK officials
    public function index()
    {
        $chairpersons = RunningSk::with('feedbacks')->where('position', 'SK Chairperson')->get();

        $members = RunningSk::with('feedbacks')->where('position', 'SK Kagawad')->get();

        // Check if user is admin - if so, show admin view, otherwise show public view
        if (auth('admin')->check()) {
            return view('runningsk.index', compact('chairpersons', 'members'));
        } else {
            return view('runningsk.public', compact('chairpersons', 'members'));
        }
    }

    public function show(RunningSk $runningsk)
    {
        $runningsk->load('feedbacks');
        return view('runningsk.show', compact('runningsk'));
    }

    public function create()
    {
        return view('runningsk.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fname' => 'required|string',
            'middle_initial' => 'nullable|string|max:10',
            'lname' => 'required|string',
            'position' => 'required|string',
            'age' => 'required|integer',
            'address' => 'nullable|string',
            'gender' => 'required|string',
            'birthdate' => 'nullable|date',
            'platforms' => 'nullable|array',
            'platforms.*' => 'nullable|string',
            'credentials' => 'nullable|array',
            'credentials.*' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('official_photos', 'public');
        }

        // Process platforms and credentials arrays
        $data['platform'] = isset($data['platforms']) ? array_filter($data['platforms'], function($value) {
            return !empty(trim($value));
        }) : [];

        $data['credentials'] = isset($data['credentials']) ? array_filter($data['credentials'], function($value) {
            return !empty(trim($value));
        }) : [];

        // Remove the temporary array fields
        unset($data['platforms'], $data['credentials']);

        RunningSk::create($data);

        return redirect()->route('admin.runningsk.index')->with('success', 'Official added.');
    }

    public function edit($id)
    {
        $official = RunningSk::findOrFail($id);
        return view('runningsk.edit', compact('official'));
    }

    public function update(Request $request, $id)
    {
        $official = RunningSk::findOrFail($id);

        $data = $request->validate([
            'fname' => 'required|string|max:50',
            'middle_initial' => 'nullable|string|max:10',
            'lname' => 'required|string|max:50',
            'position' => 'required|string',
            'age' => 'required|integer',
            'address' => 'nullable|string|max:255',
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

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('official_photos', 'public');
        }

        // Process platforms and credentials arrays
        $data['platform'] = isset($data['platforms']) ? array_filter($data['platforms'], function($value) {
            return !empty(trim($value));
        }) : [];

        $data['credentials'] = isset($data['credentials']) ? array_filter($data['credentials'], function($value) {
            return !empty(trim($value));
        }) : [];

        // Remove the temporary array fields
        unset($data['platforms'], $data['credentials']);

        $official->update($data);

        return redirect()->route('admin.runningsk.index')->with('success', 'Official updated successfully.');
    }

    public function destroy($id)
    {
        $official = RunningSk::findOrFail($id);

        if ($official->photo) {
            Storage::disk('public')->delete($official->photo);
        }

        $official->delete();

        return redirect()->route('admin.runningsk.index')->with('success', 'Official deleted successfully.');
    }

    // Mark running SK official as election winner and promote to current SK official
    public function markAsWinner($id)
    {
        try {
            $runningSk = RunningSk::findOrFail($id);

            // Debug: Check if running SK official exists and has required data
            if (!$runningSk) {
                return redirect()->back()->with('error', 'Running SK official not found.');
            }

            // SK can only have 7 members maximum
            $currentSkCount = CurrentSK::count();
            $maxMembers = 7;

            if ($currentSkCount >= $maxMembers) {
                // If at maximum, replace the oldest member (first elected)
                $oldestMember = CurrentSK::orderBy('created_at', 'asc')->first();
                if ($oldestMember) {
                    $oldestMember->delete();
                    $replacementMessage = ' Replaced oldest member (' . $oldestMember->fname . ' ' . $oldestMember->lname . ').';
                }
            } else {
                // Check if there's already a current SK official with the same position and remove them
                $existingSkOfficial = CurrentSK::where('position', $runningSk->position)->first();
                if ($existingSkOfficial) {
                    $existingSkOfficial->delete();
                }
                $replacementMessage = '';
            }

            // Create new current SK official with running SK's data
            $currentSk = CurrentSK::create([
                'fname' => $runningSk->fname,
                'middle_initial' => $runningSk->middle_initial,
                'lname' => $runningSk->lname,
                'age' => $runningSk->age,
                'address' => $runningSk->address,
                'gender' => $runningSk->gender,
                'birthdate' => $runningSk->birthdate,
                'platform' => $runningSk->platform,
                'credentials' => $runningSk->credentials,
                'photo' => $runningSk->photo,
                'position' => $runningSk->position,
                'email' => $runningSk->email,
                'phone' => $runningSk->phone,
            ]);

            // Delete the running SK official after promotion
            $runningSk->delete();

            return redirect()->route('admin.runningsk.index')->with('success', 'SK Official marked as winner and promoted to current SK officials!' . $replacementMessage);

        } catch (\Exception $e) {
            // Debug: Log the error and return with error message
            \Log::error('Mark SK as Winner Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error promoting SK official: ' . $e->getMessage());
        }
    }
}
