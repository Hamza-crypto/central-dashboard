<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Jobs\SyncDataJob;
use App\Models\FileEntry;
use Illuminate\Http\Request;
use App\Imports\GetCategories;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    public function create()
    {
        return view('pages.files.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('file');
        $filePath = $file->store('uploads');

        $file = FileEntry::create([
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
        $selected = $request->input('selected');

        if(!$selected) {
            return back()->with(['error' => 'You did not make any selection']);
        }
        // Find the model instance
        $file = FileEntry::find($file_id);
        $file->website_data = $categories;
        $file->save();

        // Dispatch the job
        SyncDataJob::dispatch($file_id);

        return back()->with([
            'success' => 'Sync operation started in background'
        ]);
    }




}
