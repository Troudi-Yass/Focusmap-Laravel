<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;  // Added Http facade
use Illuminate\Support\Facades\Cache; // Added for caching

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $goals = Goal::where('user_id', $user->id)->get();
        return view('goals.index', compact('goals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('goals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|string',
            'category' => 'required|string',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'location_name' => 'nullable|string|max:255'
        ]);

        $goal = $request->user()->goals()->create([
            ...$validated,
            'status' => 'just_started',
            'progress' => 0
        ]);

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Goal created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goal)
    {
        $this->authorize('view', $goal);
        $goal->load('tasks', 'activities');
        return view('goals.show', compact('goal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goal)
    {
        $this->authorize('update', $goal);
        return view('goals.edit', compact('goal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'category' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:not_started,in_progress,completed',
            'progress' => 'nullable|integer|min:0|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'location_name' => 'nullable|string|max:255'
        ]);

        $changes = array_diff_assoc($validated, $goal->toArray());
        $goal->update($validated);

        Activity::log(
            'goal_updated',
            "Updated goal: {$goal->title}",
            $changes
        );

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Goal updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal)
    {
        $this->authorize('delete', $goal);
        $goalTitle = $goal->title;
        $goal->delete();

        Activity::log(
            'goal_deleted',
            "Deleted goal: {$goalTitle}",
            $goal->toArray()
        );

        return redirect()->route('goals.index')
            ->with('success', 'Goal deleted successfully');
    }

    /**
     * Update goal progress
     */
    public function updateProgress(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);

        $request->validate([
            'progress' => 'required|integer|min:0|max:100'
        ]);

        $goal->update([
            'progress' => $request->progress,
            'status' => $request->progress >= 100 ? 'completed' : 'in_progress'
        ]);

        Activity::log(
            'progress_updated',
            "Updated progress for goal: {$goal->title} to {$request->progress}%",
            ['progress' => $request->progress]
        );

        return response()->json([
            'success' => true,
            'progress' => $goal->progress,
            'status' => $goal->status
        ]);
    }

    /**
     * Search locations using Nominatim
     */
    public function searchLocation(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:3'
        ]);

        try {
            $response = Http::withHeaders([
                'User-Agent' => config('app.name').'/1.0'
            ])->get('https://nominatim.openstreetmap.org/search', [
                'format' => 'json',
                'q' => $request->query,
                'limit' => 5
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Failed to fetch locations'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Reverse geocode coordinates
     */
    public function reverseGeocode(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lon' => 'required|numeric|between:-180,180'
        ]);

        try {
            $response = Http::withHeaders([
                'User-Agent' => config('app.name').'/1.0'
            ])->get('https://nominatim.openstreetmap.org/reverse', [
                'format' => 'json',
                'lat' => $request->lat,
                'lon' => $request->lon
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Failed to reverse geocode'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}