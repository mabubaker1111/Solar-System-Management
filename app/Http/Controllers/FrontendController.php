<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business\Business;

class FrontendController extends Controller
{
    public function index()
    {
        $businesses = Business::all(); // dropdown ke liye
        return view('frontend.index', compact('businesses'));
    }

    public function about()
    {
        $businesses = Business::all(); // zarurat ho to pass karo
        return view('frontend.about', compact('businesses'));
    }

    public function services()
    {
        $businesses = Business::all();
        return view('frontend.services', compact('businesses'));
    }

    public function contact()
    {
        $businesses = Business::all();
        return view('frontend.contact', compact('businesses'));
    }
}
