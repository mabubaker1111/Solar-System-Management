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
        try {
            // Sirf approved businesses fetch karo
            $businesses = Business::where('status', 'approved')->get();
            return view('frontend.services', compact('businesses'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load businesses: ' . $e->getMessage());
        }
    }


    public function contact()
    {
        $businesses = Business::all();
        return view('frontend.contact', compact('businesses'));
    }
    public function browseBusinesses()
    {
        try {
            $businesses = Business::where('status', 'approved')->get();
            return view('frontend.services', compact('businesses'));
        } catch (\Exception $b) {
            return back()->with('error', 'Failed to load businesses: ' . $b->getMessage());
        }
    }

    public function businessDetails($id)
    {
        try {
            // Sirf approved businesses ka data
            $business = Business::with(['services', 'owner'])
                ->where('status', 'approved')
                ->findOrFail($id);

            return view('client.business_details', compact('business'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load business details: ' . $e->getMessage());
        }
    }
    public function homePage()
    {
        try {
            // Sirf approved businesses fetch karo
            $businesses = Business::where('status', 'approved')->get();
            return view('frontend.index', compact('businesses'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load home page: ' . $e->getMessage());
        }
    }
}
