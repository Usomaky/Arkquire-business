<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function index()
    {
        // dd($businesses);
        
        $businesses = Business::orderBy('created_at', 'desc')->get();
        return Inertia::render('Admin/Businesses', [
            'businesses' =>  $businesses
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $business = Business::findOrFail($id);
        $business->business_status = $request->input('status');
        $business->save();

        return redirect()->back()->with('message', 'Business status updated successfully!');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     */

    public function destroy($id)
    {
        $business = Business::findOrFail($id);

        if ($business->delete()) {
            return redirect()->back()->with('flash', ['message' => 'Category deleted successfully']);
        } else {
            return redirect()->back()->with('flash', ['message' => 'Failed to delete category']);
        }
    }

    public function disable($id)
    {
        $business = Business::findOrFail($id);
        $business->update(['business_state' => false]); // Set status to false to disable
        // session()->flash('flash', ['message' => 'Category disabled successfully']);

        // return Inertia::location('/admin/businesses');
        // return redirect()->to('/admin/dashboard')->with('flash', ['message' => 'Category disabled successfully']);
        $user = Auth::user();
        if ($user->usertype === 'admin') {
            return Inertia::location('/admin/businesses');
        }

        if ($user->usertype === 'super_admin') {
            return Inertia::location('/super_admin/businesses');
        }
    }

    public function enable($id)
    {
        $business = Business::findOrFail($id);
        $business->update(['business_state' => true]); // Set status to true to enable
        // return Inertia::location('/admin/businesses');
        $user = Auth::user();
        if ($user->usertype === 'admin') {
            return Inertia::location('/admin/businesses');
        }

        if ($user->usertype === 'super_admin') {
            return Inertia::location('/super_admin/businesses');
        }
    }



    /**
     * Update the specified business in storage.
     *
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'business_name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'business_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'business_type' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'property_id' => 'required|integer|exists:properties,id',
            'age' => 'required|integer|min:0|max:' . (date('Y') - 1900),
            'business_number' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'lga' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'landmark' => 'nullable',
            // 'property_type' => 'required|string|max:255',
            'staffs' => 'required|min:0',
            'transaction_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'profit_margin' => 'required|numeric|min:0|max:100',
        ]);

        // Find the business by ID
        $business = Business::findOrFail($id);

        // Update the business with the request data
        $business->update([
            'business_name' => $request->business_name,
            'status' => $request->status,
            'business_year' => $request->business_year,
            'business_type' => $request->business_type,
            'category_id' => $request->category_id,
            'property_id' => $request->property_id,
            'age' => $request->age,
            'business_number' => $request->business_number,
            'description' => $request->description,
            'address' => $request->address,
            'lga' => $request->lga,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'landmark' => $request->landmark,
            // 'property_type' => $request->property_type,
            'staffs' => $request->staffs,
            'transaction_type' => $request->transaction_type,
            'price' => $request->price,
            'profit_margin' => $request->profit_margin,
        ]);

        // return Inertia::location('/admin/businesses');
        $user = Auth::user();
        if ($user->usertype === 'admin') {
            return Inertia::location('/admin/businesses');
        }

        if ($user->usertype === 'super_admin') {
            return Inertia::location('/super_admin/businesses');
        }

        // Return a response
        // return redirect()->back()->with('success', 'Business updated successfully!');
    }

//implement flash messages

}


