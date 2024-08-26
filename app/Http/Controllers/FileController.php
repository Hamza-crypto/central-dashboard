<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Jobs\SyncDataJob;
use App\Models\File;
use Illuminate\Http\Request;
use App\Imports\GetCategories;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    public function create()
    {
        $files = File::with('websites')->has('websites')->latest()->limit(5)->get();
        return view('pages.files.add', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('file');
        $filePath = $file->store('uploads');

        // Get the original filename
        $fileName = $file->getClientOriginalName();

        $file = File::create([
            'name' => $fileName,
            'filepath' => $filePath
        ]);

        // $filePath = "uploads/nlGiFGKcu61iTVqjXf5pqTwvfU97H5Bv4T9gdeeK.xlsx";
        $filePath = storage_path('app/' . $filePath);

        $categories = Excel::import(new GetCategories(), $filePath);
        $categories = GetCategories::$categories;

        // Remove the first element
        array_shift($categories);

        $categories = array_unique($categories);

        $websites = Website::all();

        return back()->with([
            'id' => $file->id,
            'categories' => $categories,
            'websites' => $websites
        ]);
    }

    public function sync_data(Request $request)
    {
        $file_id = $request->input('id');
        $categories = $request->input('categories');
        $selectedWebsites = $request->input('selected');

        if(!$selectedWebsites) {
            return back()->with(['error' => 'You did not make any selection']);
        }
        // Find the model instance
        $file = File::find($file_id);
        $file->website_data = $categories;
        $file->save();

        $file->websites()->attach($selectedWebsites);

        // Dispatch the job
        SyncDataJob::dispatch($file_id);

        return back()->with([
            'success' => 'Sync operation started in background'
        ]);
    }

    public function deleteAll()
    {
        \DB::table('file_website')->truncate();
        return redirect()->back()->with('success', 'History cleared successfully.');
    }
}
