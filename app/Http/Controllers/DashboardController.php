<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;

class DashboardController extends Controller
{
    public function index()
    {
        $website = Website::find(1);
        $websites = Website::all();

        if ($website) {
            $stats = $website->stats;

            // Pass stats to the view
            return view('pages.dashboard.index', compact('stats', 'websites'));


            $websites = Website::all();
            return view('pages.dashboard.index', compact('websites'));
        }
    }
}
