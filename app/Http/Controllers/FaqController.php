<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Business;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqData = Faq::all();
        // $faqData = [
        //     [
        //         'header' => 'What is Arkquire',
        //         'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, ...'
        //     ],
        //     [
        //         'header' => 'Header II',
        //         'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem ...'
        //     ],
        //     [
        //         'header' => 'Header III',
        //         'content' => 'At vero eos et accusamus et iusto odio dignissimos ducimus ...'
        //     ]
        // ];
        return Inertia::render('Faq', [
            'faqData' => $faqData
        ]);
    }

}

