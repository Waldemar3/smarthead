<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\View;

class WidgetController extends Controller
{
    public function index(): Response
    {
        return response()
            ->view('widget.index')
            ->header('X-Frame-Options', 'ALLOWALL')
            ->header('Content-Security-Policy', 'frame-ancestors *');
    }

    public function demo(): View
    {
        return view('widget-demo.index');
    }
}
