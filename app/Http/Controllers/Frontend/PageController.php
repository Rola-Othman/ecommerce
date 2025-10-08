<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Contact;
use App\Models\About;
use App\Models\EmailConfiguration;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    /**
     * Display the contact page.
     * عرض صفحة اتصل بنا.
     * @return View
     */
    public function contact()
    {
        return view('frontend.pages.contact');
    }

    /**
     * Handle the contact form submission.
     * معالجة إرسال نموذج الاتصال.
     * @param Request $request
     * @return Response
     */
    public function handleContactForm(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'max:200'],
            'message' => ['required', 'max:1000']
        ]);

        $setting = EmailConfiguration::first();

        Mail::to($setting->email)->send(new Contact($request->subject, $request->message, $request->email));

        return response(['status' => 'success', 'message' => 'Mail sent successfully!']);
    }

}
