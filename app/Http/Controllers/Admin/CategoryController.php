<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return Inertia::render('Admin/Category', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        // return redirect()->route('categories.index');
    }


    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        // Find the category by ID
        $category = Category::findOrFail($request->id);

        // Update the category with the request data
        $category->update($request->only('category_name'));

        // return redirect()->route('categories.index');
    }



    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     */

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->delete()) {
            return redirect()->back()->with('flash', ['message' => 'Category deleted successfully']);
        } else {
            return redirect()->back()->with('flash', ['message' => 'Failed to delete category']);
        }
    }

    public function disable($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['status' => false]); // Set status to false to disable

        $user = Auth::user();
        if ($user->usertype === 'admin') {
            return Inertia::location('/admin/category');
        }

        if ($user->usertype === 'super_admin') {
            return Inertia::location('/super_admin/category');
        }
    }

    public function enable($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['status' => true]); // Set status to true to enable


        $user = Auth::user();
        if ($user->usertype === 'admin') {
            return Inertia::location('/admin/category');
        }

        if ($user->usertype === 'super_admin') {
            return Inertia::location('/super_admin/category');
        }
    }
}
//implement flash messages
