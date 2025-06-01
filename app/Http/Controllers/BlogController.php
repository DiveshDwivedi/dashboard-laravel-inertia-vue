<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function show() {
        return Inertia::render('Blogs/Show');
    }
}
