<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SistemDurumController extends Controller
{
    public function index()
    {
        return view('admin.sistem_durum');
    }
}
