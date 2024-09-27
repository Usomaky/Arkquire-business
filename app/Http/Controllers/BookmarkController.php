<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BookmarkController extends Controller
{
    public function index()
    {

        // $business = Business::with('category', 'images')->findOrFail($id);
        $bookmarks = Auth::user()->bookmarks()->with('category', 'images')->get();

        // $bookmarks = $user ? $user->bookmarks : [];

        return Inertia::render('Bookmark', [
            'bookmarks' => $bookmarks,
        ]);
    }

    public function store(Request $request)
    {
        $bookmark = Bookmark::firstOrCreate(
            ['user_id' => auth()->id(), 'business_id' => $request->business_id]
        );

        return redirect()->back()->with('message', 'Business bookmarked successfully!');
    }

    public function destroy($id)
    {
        $bookmark = Bookmark::where('user_id', auth()->id())->where('business_id', $id)->first();

        if ($bookmark) {
            $bookmark->delete();
            return redirect()->back()->with('message', 'Business removed from bookmarks!');
        }

        return redirect()->back()->with('error', 'Failed to remove the business from bookmarks.');
    }

    public function destroyAll()
    {
        Auth::user()->bookmarks()->delete();
        // Redirect back to the previous page using Inertia
        return Redirect::back()->with('success', 'All bookmarks removed successfully');
    }
}
