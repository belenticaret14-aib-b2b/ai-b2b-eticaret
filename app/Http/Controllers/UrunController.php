<?php

namespace App\Http\Controllers;

use App\Models\Urun;
use Illuminate\Http\Request;

class UrunController extends Controller
{
    public function index()
    {
        $urunler = Urun::all();
        return view('urunler.index', compact('urunler'));
    }
}
