<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function store(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required|max:12'
        ]);

        if (! Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            return redirect()->route('auth.login.index')
                ->with('error', 'Invalid login credentials');
        }

        return redirect()->route('main.timeline.index');
    }
}
