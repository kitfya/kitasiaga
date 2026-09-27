<?php

namespace App\Http\Controllers;

use App\Models\Korban;
use App\Models\Laporan;
use App\Models\Posko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KorbanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $poskoRelawan = $user->relawan?->posko;

        $query = Korban::with(['posko', 'laporan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('kebutuhan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('posko_id') && $request->posko_id !== 'all') {
            $query->where('posko_id', $request->posko_id);
        }

        if ($request->filled('kondisi') && $request->kondisi !== 'all') {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('kelompok_rentan') && $request->kelompok_rentan !== 'all') {
            $query->where('kelompok_rentan', $request->kelompok_rentan);
        }

        $victims = $query->latest()->get();

        $allVictims = Korban::all();
        $summary = [
            'total' => $allVictims->count(),
            'kritis' => $allVictims->where('kondisi', 'Kritis')->count(),
            'luka' => $allVictims->where('kondisi', 'Luka-luka')->count(),
            'sehat' => $allVictims->where('kondisi', 'Sehat')->count(),
            'rentan' => $allVictims->whereIn('kelompok_rentan', ['Bayi/Balita', 'Lansia', 'Hamil', 'Disabilitas'])->count(),
        ];

        $poskoList = Posko::all();
        $laporanList = Laporan::all();

        return view('korban', compact(
            'victims',
            'summary',
            'poskoList',
            'laporanList',
            'poskoRelawan'
        ));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'laporan_id' => 'required',
        'posko_id' => 'required|exists:poskos,id',
        'name' => 'required|string|max:255', // <-- Ubah 'nama' jadi 'name'
        'usia' => 'required|numeric|min:0|max:120',
        'nik' => 'nullable|string|max:16',
        'kondisi' => 'required|string',
        'kelompok_rentan' => 'required|string',
        'kebutuhan' => 'nullable|string',
    ]);

    $korban = Korban::create($validated);

    Posko::where('id', $request->posko_id)->increment('jumlah_pengungsi');

    return redirect()->back()->with('success', 'Data korban berhasil ditambahkan.');
}

public function update(Request $request, Korban $korban)
{
    $validated = $request->validate([
        'laporan_id' => 'required',
        'posko_id' => 'required|exists:poskos,id',
        'name' => 'required|string|max:255', // <-- Ubah 'nama' jadi 'name'
        'usia' => 'required|numeric|min:0|max:120',
        'nik' => 'nullable|string|max:16',
        'kondisi' => 'required|string',
        'kelompok_rentan' => 'required|string',
        'kebutuhan' => 'nullable|string',
    ]);

    $oldPoskoId = $korban->posko_id;
    $newPoskoId = $request->posko_id;

    $korban->update($validated);

    if ($oldPoskoId != $newPoskoId) {
        if ($oldPoskoId) {
            Posko::where('id', $oldPoskoId)->decrement('jumlah_pengungsi');
        }
        Posko::where('id', $newPoskoId)->increment('jumlah_pengungsi');
    }

    return redirect()->back()->with('success', 'Data korban berhasil diperbarui.');
}
    
    public function destroy(Korban $korban)
    {
        $poskoId = $korban->posko_id;

        $korban->delete();

        if ($poskoId) {
            Posko::where('id', $poskoId)->decrement('jumlah_pengungsi');
        }

        return redirect()->back()->with('success', 'Data korban berhasil dihapus.');
    }
}
