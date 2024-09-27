<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;


class FaqController extends Controller
{
    public function index()
    {
        $faqData = Faq::all();
        return Inertia::render('Admin/Faq', [
            'faqData' => $faqData
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'faq_header' => 'required|text',
            'faq_content' => 'required|text',
        ]);

        Faq::create($request->all());

        // return redirect()->route('categories.index');
    }


    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'faq_header' => 'required|text',
            'faq_content' => 'required|text',            
             ]);

        // Find the category by ID
        $Faq = Faq::findOrFail($request->id);

        // Update the category with the request data
        $Faq->update($request->only('faq_header'));
        $Faq->update($request->only('faq_content'));

        // return redirect()->route('categories.index');
    }



    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     */

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);

        if ($faq->delete()) {
            return redirect()->back()->with('flash', ['message' => 'Faq deleted successfully']);
        } else {
            return redirect()->back()->with('flash', ['message' => 'Failed to delete Faq']);
        }
    }

    
}
//implement flash messages
