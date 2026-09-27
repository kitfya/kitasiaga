<?php

namespace App\Http\Controllers;

use App\Events\LaporanMasuk;
use App\Models\Laporan;
use App\Models\Posko;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WelcomeController extends Controller
{
    public function index()
    {
        $poskoList = Posko::where('is_active', true)->get();

        $publicReports = Laporan::where('is_valid', true)
            ->latest()
            ->take(6)
            ->get();

        $totalPosko = $poskoList->count();
        $totalPengungsi = $poskoList->sum('jumlah_pengungsi');
        $totalKapasitas = $poskoList->sum('kapasitas');
        $kapasitasTersedia = max(0, $totalKapasitas - $totalPengungsi);

        return view('welcome', compact(
            'poskoList',
            'publicReports',
            'totalPosko',
            'totalPengungsi',
            'kapasitasTersedia'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'tipe' => 'required|string',
            'description' => 'required|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('bukti_laporan', 'public');
            $validated['bukti'] = $path;
        }

        $validated['kode'] = 'LAP-'.strtoupper(Str::random(6));
        $validated['is_valid'] = false; 
        $laporan = Laporan::create($validated);
        
        try {
        event(new LaporanMasuk($laporan));
    } catch (\Throwable $e) {
\Illuminate\Support\Facades\Log::error('Broadcast Reverb/Pusher Error: ' . $e->getMessage());
    }
        return response()->json([
        'success' => true,
        'message' => 'Laporan darurat berhasil dikirim dan menunggu verifikasi relawan.',
        'data' => $laporan,
    ]);
    }
}
