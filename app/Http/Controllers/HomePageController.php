<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Business;

class HomePageController extends Controller
{
    public function index()
    {
        $featuredCategories = Category::take(9)->get();
        $categories = Category::all();
        $businesses = Business::with('category', 'images')
            ->where('status', 'approved')
        ->orderBy('created_at', 'desc')->take(10)->get();
   

        // dd($categories);

        return Inertia::render('Home', [
            'featuredCategories' => $featuredCategories,
            'categories' => $categories,
            'businesses' => $businesses
        ]);

    }
}
