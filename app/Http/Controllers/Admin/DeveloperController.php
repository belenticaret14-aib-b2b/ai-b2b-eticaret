<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DeveloperController extends Controller
{
    public function index()
    {
        return view('admin.developer');
    }
}
