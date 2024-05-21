<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class StaticPages extends Controller
{
    /*
     * Display the Dashboard view
     */
    public function dashboard(): View
    {
        return view('pages.dashboard');
    }

    /*
     * Display the Welcome view
     */
    public function welcome(): View
    {
        return view('pages.welcome');
    }

    /*
     * Display the About view
     */
    public function about(): View
    {
        return view('pages.about');
    }

    /*
     * Display the Contact Us view
     */
    public function contact_us(): View
    {
        return view('pages.contact-us');
    }

    /*
     * Display the Pricing view
     */
    public function pricing(): View
    {
        return view('pages.pricing');
    }
}
