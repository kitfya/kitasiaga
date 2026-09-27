<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Logistik;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $posko = $user->relawan?->posko;
        $korban = $posko ? $posko->korban : collect();

        $laporanPending = Laporan::where('is_valid', false)->count();
        $laporan = Laporan::count();

        $laporanList = Laporan::latest()->get();

        $logistik = Logistik::count();
        $logistikMenipis = Logistik::where('jumlah', '<', 100)->count();

        return view('dashboard', compact(
            'user',
            'posko',
            'korban',
            'laporanPending',
            'laporan',
            'logistik',
            'logistikMenipis',
            'laporanList'
        ));
    }
}
