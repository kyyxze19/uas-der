<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
 public function index()
{
    $karyawan = Auth::user(); // ini penting!

    return view('karyawan.dashboard', compact('karyawan'));
}
}
