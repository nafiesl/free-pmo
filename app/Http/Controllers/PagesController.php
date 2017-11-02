<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'queriedYear' => request('year', date('Y')),
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

}
