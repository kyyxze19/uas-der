<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Proyek;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data proyek bulan ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // Count proyek berdasarkan status dalam bulan ini
        $proyekSelesai = Proyek::where('status_proyek', 'selesai')
            ->whereMonth('tanggal_mulai', $currentMonth)
            ->whereYear('tanggal_mulai', $currentYear)
            ->count();
            
        $proyekBelumSelesai = Proyek::where('status_proyek', 'belum selesai')
            ->whereMonth('tanggal_mulai', $currentMonth)
            ->whereYear('tanggal_mulai', $currentYear)
            ->count();
            
        $proyekBerjalan = Proyek::where('status_proyek', 'berjalan')
            ->whereMonth('tanggal_mulai', $currentMonth)
            ->whereYear('tanggal_mulai', $currentYear)
            ->count();
        
        // Data untuk chart
        $chartData = [
            'selesai' => $proyekSelesai,
            'belum_selesai' => $proyekBelumSelesai,
            'berjalan' => $proyekBerjalan
        ];
        
        return view('dashboard', compact('chartData'));
    }
}