<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     ** Display the about page.
     ** عرض صفحة من نحن.
     * @return View
     */
     public function about()
    {
        $about = About::first();
        return view('frontend.pages.about', compact('about'));
    }

    /**
     * Display the terms and conditions page.
     * عرض صفحة الشروط والأحكام.
     * @return View
     */
     public function termsAndCondition()
    {
        $terms = TermsAndCondition::first();
        return view('frontend.pages.terms-and-condition', compact('terms'));
    }
}
