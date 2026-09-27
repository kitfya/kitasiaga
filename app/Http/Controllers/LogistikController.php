<?php

namespace App\Http\Controllers;

use App\Models\Logistik;
use App\Models\Posko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogistikController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $poskoRelawan = $user->relawan?->posko;

        $query = Logistik::with('posko');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('posko_id') && $request->posko_id !== 'all') {
            $query->where('posko_id', $request->posko_id);
        }

        if ($request->filled('tipe') && $request->tipe !== 'all') {
            $query->where('tipe', $request->tipe);
        }

        $logistics = $query->latest()->get();

        $allLogistics = Logistik::all();
        $summary = [
            'total_item' => $allLogistics->count(),
            'total_stok' => $allLogistics->sum('jumlah'),
            'obat' => $allLogistics->where('tipe', 'obat')->sum('jumlah'),
            'makanan' => $allLogistics->where('tipe', 'makanan')->sum('jumlah'),
            'pakaian' => $allLogistics->where('tipe', 'pakaian')->sum('jumlah'),
            'lainnya' => $allLogistics->where('tipe', 'lainnya')->sum('jumlah'),
            'menipis' => $allLogistics->where('jumlah', '<=', 50)->count(),
        ];

        $poskoList = Posko::all();

        return view('logistik', compact(
            'logistics',
            'summary',
            'poskoList',
            'poskoRelawan'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tipe' => 'required|in:obat,makanan,pakaian,lainnya',
            'jumlah' => 'required|integer|min:0',
            'posko_id' => 'required|exists:poskos,id',
        ]);

        Logistik::create($validated);

        return redirect()->back()->with('success', 'Data logistik berhasil ditambahkan.');
    }

    public function update(Request $request, Logistik $logistik)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tipe' => 'required|in:obat,makanan,pakaian,lainnya',
            'jumlah' => 'required|integer|min:0',
            'posko_id' => 'required|exists:poskos,id',
        ]);

        $logistik->update($validated);

        return redirect()->back()->with('success', 'Data logistik berhasil diperbarui.');
    }

    public function destroy(Logistik $logistik)
    {
        $logistik->delete();

        return redirect()->back()->with('success', 'Data logistik berhasil dihapus.');
    }
}
