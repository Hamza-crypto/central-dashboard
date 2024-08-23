<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;

class DashboardController extends Controller
{
    public function index()
    {
        $websites = Website::whereNotNull('stats')->get();
        return view('pages.dashboard.index', compact('websites'));
    }

    public function stats(Request $request)
    {
        $website = Website::find($request->input('id'));

        if ($website) {
            // Return the stats as JSON response
            return response()->json($website->stats);
        } else {
            // Return a 404 response if the website is not found
            return response()->json(['error' => 'Website not found'], 404);
        }

    }
}
