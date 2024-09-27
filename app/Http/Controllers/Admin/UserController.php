<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // dd($users);
        return Inertia::render('Admin/Users', [
            'users'=> $users
        ]);
    }

    public function updateStatus(Request $request, $userId)
    {
        $request->validate([
            'status' => 'required|string|in:active,disabled'
        ]);

        $user = User::findOrFail($userId); // Find the user by ID
        $user->status = $request->status;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }
    public function updateType(Request $request, $userId)
    {
        $request->validate([
            'usertype' => 'required|string|in:customer,admin,super_admin'
        ]);

        $user = User::findOrFail($userId); // Find the user by ID
        $user->usertype = $request->usertype;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');

        // dd($request);
    }
}
