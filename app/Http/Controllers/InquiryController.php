<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $business = Business::with('category', 'images')->findOrFail($id);
        $inquiries = Inquiry::where('user_id', request()->user()->id )->get();

        // $bookmarks = $user ? $user->bookmarks : [];

        return Inertia::render('Inquiry', [
            'inquiries' => $inquiries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sendInquiry = $request->validate([
            'user_id' => 'required|exists:users,id',
            'business_id' => 'required|exists:businesses,id',
            'message' => 'required|string|min:5',
        ]);

        Inquiry::create([
            'user_id' => $sendInquiry['user_id'],
            'business_id' => $sendInquiry['business_id'],
            'message' => $sendInquiry['message'],
        ]);

        return redirect()->back()->with('message', 'Inquiry sent successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inquiry $inquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquiry $inquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inquiry $inquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        //
    }
}
