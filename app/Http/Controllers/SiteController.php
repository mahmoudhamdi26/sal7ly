<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SiteController extends Controller
{

    public function index()
    {
        //return view('welcome');
        return Redirect::to(action('HomeController@index'));
    }
}
