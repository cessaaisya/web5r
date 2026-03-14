<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credential = $request->input('credential');
        $password = $request->input('password');

        // Try to authenticate using nim or no_reg
        $user = \App\Models\User::where('nim', $credential)
            ->orWhere('no_reg', $credential)
            ->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            Auth::login($user);

            // Redirect based on role
            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard.admin');
            } elseif ($user->hasRole('management')) {
                return redirect()->route('dashboard.management');
            } else {
                // Default to student dashboard
                return redirect()->route('dashboard.student');
            }
        }

        return back()->withErrors(['credential' => 'Invalid NIM/Registration Number or Password']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
