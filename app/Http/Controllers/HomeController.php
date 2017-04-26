<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {
    public function index()
    {
        $pages_css[] = 'css/owl.carousel.css';
        $pages_css[] = 'css/owl.theme.css';
        $pages_js[] = 'js/owl.carousel.min.js';

        return view('index', compact('pages_css', 'pages_js'));
    }
}
