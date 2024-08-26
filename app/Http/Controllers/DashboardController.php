<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;

class DashboardController extends Controller
{
    public function index()
    {
        $websites = Website::get();
        return view('pages.dashboard.index', compact('websites'));
    }

    public function stats(Request $request)
    {

        $web_id = $request->input('website_id');

        $website = Website::find($web_id);


        if ($website) {
            $col_name = "stats_" . $request->input('period');
            // Return the stats as JSON response
            return response()->json($website->$col_name);
        } else {
            // Return a 404 response if the website is not found
            return response()->json(['error' => 'Website not found'], 404);
        }

    }
}
