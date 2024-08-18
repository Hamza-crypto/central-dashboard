<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('pages.websites.index');
    }

    public function create()
    {
        return view('pages.websites.add');
    }
}