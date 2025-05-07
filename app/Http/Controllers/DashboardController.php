<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;
use App\Models\Task;
use App\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        $goals = auth()->user()->goals()->with(['tasks', 'activities'])->latest()->get();
        return view('dashboard', compact('goals'));
    }
}
