<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Business;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\TransactionTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // public function index($id)
    // {
    //     return Inertia::render('Businesses', [
    //         'auction' => Business::where('transaction_type', TransactionTypes::Auction->value)
    //             ->where('status', 'approved')
    //             ->where('business_status', 'unsold')
    //             ->where('business_state', true)
    //             ->where('category_id', $id)

    //             ->with('images', 'category')->get()->take(20),
    //         'sale' => Business::where('transaction_type', TransactionTypes::Sale->value)
    //             ->where('status', 'approved')
    //             ->where('business_status', 'unsold')
    //             ->where('category_id', 2)
    //             ->with('images', 'category')->paginate(),
    //         'investment' => Business::where('transaction_type', TransactionTypes::Investment->value)
    //             ->where('status', 'approved')
    //             ->where('business_status', 'unsold')
    //             ->where('business_state', true)->with('images', 'category')->paginate(),
    //         'lease' => Business::where('transaction_type', TransactionTypes::Lease->value)
    //             ->where('status', 'approved')
    //             ->where('business_status', 'unsold')
    //             ->where('business_state', true)->with('images', 'category')->paginate(),
    //     ]);
    // }

    public function show()
    {
        return Inertia::render('Post', [
            'categories' => Category::where('status', true)->get(),
            'properties' => Property::where('status', true)->get(),
            'transaction_types' => TransactionTypes::toObject()
        ]);
    }

    public function category($id)
    {
        $business = Business::where('category_id', $id)
            ->with('images', 'category', 'watchers', 'owner')->first();

        // Fetch the user's bookmarks (assuming you have user authentication)
        $user = auth()->user();
        $bookmarks = $user ? $user->bookmarks : [];

        return Inertia::render('Businesses', [

            'user' => $user,
            'business' => $business,
            'bookmarks' => $bookmarks,
            'isLoggedIn' => Auth::check(),

            'auction' => Business::where('transaction_type', TransactionTypes::Auction->value)
                ->where('status', 'approved')
                ->where('business_status', 'unsold')
                ->where('business_state', true)
                ->where('category_id', $id)

                ->with('images', 'category')->get()->take(20),
            'sale' => Business::where('transaction_type', TransactionTypes::Sale->value)
                ->where('status', 'approved')
                ->where('business_status', 'unsold')
                ->where('category_id', $id)
                ->with('images', 'category')->paginate(),
            'investment' => Business::where('transaction_type', TransactionTypes::Investment->value)
                ->where('status', 'approved')
                ->where('business_status', 'unsold')
                ->where('category_id', $id)
                ->where('business_state', true)->with('images', 'category')->paginate(),
            'lease' => Business::where('transaction_type', TransactionTypes::Lease->value)
                ->where('status', 'approved')
                ->where('business_status', 'unsold')
                ->where('category_id', $id)
                ->where('business_state', true)->with('images', 'category')->paginate(),

        ]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'business_name' => 'required|unique:businesses,business_name',
                'business_year' => 'required|digits:4',
                'business_type' => 'required',
                'category_id' => 'required',
                'property_id' => 'required',
                'age' => 'required',
                'business_number' => 'required|unique:businesses,business_number',
                'description' => 'required',
                'address' => 'nullable',
                'lga' => 'nullable',
                'city' => 'nullable',
                'state' => 'nullable',
                'country' => 'nullable',
                'landmark' => 'nullable',
                // 'property_type' => 'required',
                'staffs' => 'required',
                'photos' => 'required',
                'transaction_type' => 'required',
                'price' => 'required',
                'profit_margin' => 'required',
                'ends' => 'nullable',
                'properties' => 'nullable'
            ],
            [
                'business_number.unique' => 'Reg. number has been used!'
            ]
        );

        $user = $request->user();

        $business = $user->businesses()->create(
            $request->only(
                [
                    'business_name',
                    'business_year',
                    'business_number',
                    'business_type',
                    // 'property_type',
                    'staffs',
                    'category_id',
                    'property_id',
                    'description',
                    'transaction_type',
                    'address',
                    'lga',
                    'city',
                    'state',
                    'country',
                    'landmark',
                    'price',
                    'profit_margin',
                    'age',
                    'ends',
                ]
            ) + ['listing_id' => generateUID()]
        );


        foreach ($request->photos as $file) {
            $extension = $file->extension();
            $filename = Str::random(50) . ".$extension";

            // File Storage
            $path = $file->storePubliclyAs(
                'public/businesses',
                $filename
            );

            $url = Storage::url($path);

            $business->images()->create([
                'url' => $url,
                'path' => $path,
            ]);
        }

        return redirect()->back()->with('message', 'Business has been created and under review, you will been notified via email once approved!');
    }

    public function update(Request $request)
    {
    }
}
