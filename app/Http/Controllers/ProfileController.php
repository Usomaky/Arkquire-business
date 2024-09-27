<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'fullname' => 'required',
            'phone' => 'required',
            'current_password' => 'required',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Verify the current password
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update user's profile information
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('flash', ['message' => 'Profile updated successfully']);
    }
}
