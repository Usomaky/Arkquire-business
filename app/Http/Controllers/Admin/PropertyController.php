<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;


class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::all();
        return Inertia::render('Admin/Property', [
            'properties' => $properties
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'property_name' => 'required|string|max:255',
        ]);

        Property::create($request->all());

        // return redirect()->route('properties.index');
    }


    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'property_name' => 'required|string|max:255',
        ]);

        // Find the property by ID
        $property = Property::findOrFail($request->id);

        // Update the property with the request data
        $property->update($request->only('property_name'));

        // return redirect()->route('properties.index');
    }



    /**
     * Remove the specified property from storage.
     *
     * @param  int  $id
     */

    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        if ($property->delete()) {
            return redirect()->back()->with('flash', ['message' => 'Property deleted successfully']);
        } else {
            return redirect()->back()->with('flash', ['message' => 'Failed to delete Property']);
        }
    }

    public function disable($id)
    {
        $property = Property::findOrFail($id);
        $property->update(['status' => false]); // Set status to false to disable
        // session()->flash('flash', ['message' => 'property disabled successfully']);

        return Inertia::location('/admin/property');

        // return redirect()->to('/admin/dashboard')->with('flash', ['message' => 'property disabled successfully']);
    }

    public function enable($id)
    {
        $property = Property::findOrFail($id);
        $property->update(['status' => true]); // Set status to true to enable


        return Inertia::location('/admin/property');
    }
}
//implement flash messages
