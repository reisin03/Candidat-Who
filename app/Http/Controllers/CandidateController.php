<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Official;
use App\Models\RunningOfficial;
use App\Models\CurrentSk;
use App\Models\RunningSk;
use App\Models\Candidate;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $tables = [
            ['model' => Official::class, 'name_fields' => ['fname', 'middle_initial', 'lname'], 'position' => 'position'],
            ['model' => RunningOfficial::class, 'name_fields' => ['fname', 'middle_initial', 'lname'], 'position' => 'position'],
            ['model' => CurrentSk::class, 'name_fields' => ['fname', 'middle_initial', 'lname'], 'position' => 'position'],
            ['model' => RunningSk::class, 'name_fields' => ['fname', 'middle_initial', 'lname'], 'position' => 'position'],
        ];

        $candidates = collect();

        foreach ($tables as $table) {
            $candidates = $candidates->merge(
                $table['model']::when($query, function($q) use ($query, $table) {
                    return $q->where(function($subQuery) use ($query, $table) {
                        // Search name fields
                        if (isset($table['name_fields'])) {
                            foreach ($table['name_fields'] as $field) {
                                $subQuery->orWhere($field, 'like', "%{$query}%");
                            }
                        }

                        // Search position if exists
                        if (!empty($table['position'])) {
                            $subQuery->orWhere($table['position'], 'like', "%{$query}%");
                        }
                    });
                })->get()
            );
        }

        // Determine if this is an admin request
        $isAdmin = str_starts_with(request()->route()->getName(), 'admin.') ||
                   auth('admin')->check() ||
                   str_contains(request()->path(), 'admin');

        $layout = $isAdmin ? 'layouts.admin' : 'layouts.user';

        return view('candidates.index', compact('candidates', 'query', 'layout'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
