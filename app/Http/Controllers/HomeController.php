<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Muestra la vista principal (home).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }
}
