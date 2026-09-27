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

        // 1. Pencarian (Sudah diubah dari 'nama' menjadi 'name')
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('kebutuhan', 'like', "%{$search}%");
            });
        }

        // Filter Posko
        if ($request->filled('posko_id') && $request->posko_id !== 'all') {
            $query->where('posko_id', $request->posko_id);
        }

        // Filter Kondisi
        if ($request->filled('kondisi') && $request->kondisi !== 'all') {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter Kelompok Rentan
        if ($request->filled('kelompok_rentan') && $request->kelompok_rentan !== 'all') {
            $query->where('kelompok_rentan', $request->kelompok_rentan);
        }

        $victims = $query->latest()->get();

        // 2. Summary langsung dari Database (Jauh lebih cepat & efisien)
        $summary = [
            'total' => Korban::count(),
            'kritis' => Korban::where('kondisi', 'Kritis')->count(),
            'luka' => Korban::where('kondisi', 'Luka-luka')->count(),
            'sehat' => Korban::where('kondisi', 'Sehat')->count(),
            'rentan' => Korban::whereIn('kelompok_rentan', ['Bayi/Balita', 'Lansia', 'Hamil', 'Disabilitas'])->count(),
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
            'laporan_id' => 'required|exists:laporans,id', // Tambahkan exists
            'posko_id' => 'required|exists:poskos,id',
            'name' => 'required|string|max:255',
            'usia' => 'required|numeric|min:0|max:120',
            'nik' => 'nullable|string|max:16',
            'kondisi' => 'required|string',
            'kelompok_rentan' => 'required|string',
            'kebutuhan' => 'nullable|string',
        ]);

        Korban::create($validated);

        // Tambah pengungsi di posko terkait
        Posko::where('id', $request->posko_id)->increment('jumlah_pengungsi');

        return redirect()->back()->with('success', 'Data korban berhasil ditambahkan.');
    }

    public function update(Request $request, Korban $korban)
    {
        $validated = $request->validate([
            'laporan_id' => 'required|exists:laporans,id', // Tambahkan exists
            'posko_id' => 'required|exists:poskos,id',
            'name' => 'required|string|max:255',
            'usia' => 'required|numeric|min:0|max:120',
            'nik' => 'nullable|string|max:16',
            'kondisi' => 'required|string',
            'kelompok_rentan' => 'required|string',
            'kebutuhan' => 'nullable|string',
        ]);

        $oldPoskoId = $korban->posko_id;
        $newPoskoId = $request->posko_id;

        $korban->update($validated);

        // Jika posko berpindah, sesuaikan jumlah pengungsi
        if ($oldPoskoId != $newPoskoId) {
            if ($oldPoskoId) {
                Posko::where('id', $oldPoskoId)->where('jumlah_pengungsi', '>', 0)->decrement('jumlah_pengungsi');
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
            Posko::where('id', $poskoId)->where('jumlah_pengungsi', '>', 0)->decrement('jumlah_pengungsi');
        }

        return redirect()->back()->with('success', 'Data korban berhasil dihapus.');
    }
}
