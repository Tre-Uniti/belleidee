<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function about()
    {
        $first = 'Brendan';
        $last = 'McGoffin';
        return view('pages.about', compact('first','last'));
    }
    public function contact()
    {
        return view('pages.contact');
    }
    public function home()
    {
        return view('pages.home');
    }
}
