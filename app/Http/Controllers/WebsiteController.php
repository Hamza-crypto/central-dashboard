<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Website;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::all();
        return view('pages.websites.index', compact('websites'));
    }


    public function create()
    {
        return view('pages.websites.add');
    }


    public function store(Request $request)
    {
        $data = $request->all();

        // Remove trailing slash from website URL (if present)
        $data['url'] = rtrim($data['url'], "/");

        Website::create($data);
        return redirect()->route('websites.index')->with('success', 'Website created successfully');

    }

    public function edit(Website $website)
    {
        return view('pages.websites.edit', compact('website'));
    }

    public function update(Request $request, Website $website)
    {
        $website->update($request->all());

        return redirect()->route('websites.index')->with('success', 'Website updated successfully');

    }

    public function destroy(Website $website)
    {
        $website->delete();

        return redirect()->route('websites.index')->with('success', 'Website deleted successfully');

    }
}
