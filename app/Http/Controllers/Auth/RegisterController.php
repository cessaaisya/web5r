<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:student,management,admin',
            'nim' => 'required_if:role,student|nullable|string|max:255',
            'no_reg' => 'required_if:role,management,admin|nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nim' => $validated['role'] === 'student' ? $validated['nim'] : null,
            'no_reg' => in_array($validated['role'], ['management', 'admin']) ? $validated['no_reg'] : null,
        ]);

        // Attach the role to the user
        $role = \App\Models\Role::where('name', $validated['role'])->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }

        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }
}
