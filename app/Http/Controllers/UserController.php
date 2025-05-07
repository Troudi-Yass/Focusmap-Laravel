<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function destroy(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        
        return redirect('/login')->with('status', 'Account deleted successfully');
    }
}