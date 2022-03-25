<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['upload_form', 'downLoad']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function upload_form()
    {
        return view('upload_form');
    }

    public function downLoad($fileName)
    {
        // return response()->download(public_path("downloads/$fileName"));
        return Storage::disk('public')->download("uploads/$fileName");
        // return Storage::download("uploads/$fileName");
    }
}
