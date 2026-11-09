<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\Teknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeminjamanAlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['teknisi', 'alat'])
            ->where('status', 'dipinjam')
            ->latest('waktu_pinjam');

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('teknisi', function ($t) use ($keyword) {
                    $t->where('nama_teknisi', 'like', "%{$keyword}%");
                })->orWhereHas('alat', function ($a) use ($keyword) {
                    $a->where('nama_alat', 'like', "%{$keyword}%")
                        ->orWhere('kode', 'like', "%{$keyword}%");
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->paginate(10)->withQueryString();

        $teknisiList = Teknisi::orderBy('nama_teknisi')->get();
        $alatTersedia = Alat::where('status', 'tersedia')
            ->whereIn('kondisi', ['baik', 'perlu_perhatian'])
            ->orderBy('nama_alat')
            ->get();

        $mode = 'index';

        return view('transaksi.peminjaman_alat', compact(
            'peminjaman',
            'teknisiList',
            'alatTersedia',
            'mode'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teknisi_id' => [
                'required',
                'exists:teknisi,id',
            ],
            'alat_ids' => [
                'required',
                'array',
                'min:1',
            ],
            'alat_ids.*' => [
                'required',
                'distinct',
                'exists:alat,id',
            ],
        ], [
            'teknisi_id.required' => 'Silakan pilih nama teknisi.',
            'alat_ids.required' => 'Silakan pilih minimal satu alat.',
            'alat_ids.min' => 'Silakan pilih minimal satu alat.',
            'alat_ids.*.distinct' => 'Terdapat alat yang dipilih lebih dari satu kali.',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['alat_ids'] as $alatId) {
                $alat = Alat::whereKey($alatId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (
                    $alat->status !== 'tersedia' ||
                    !in_array($alat->kondisi, ['baik', 'perlu_perhatian'])
                ) {
                    throw ValidationException::withMessages([
                        'alat_ids' => "Alat {$alat->nama_alat} tidak tersedia atau kondisinya rusak.",
                    ]);
                }

                Peminjaman::create([
                    'teknisi_id' => $validated['teknisi_id'],
                    'alat_id' => $alat->id,
                    'waktu_pinjam' => now(),
                    'kondisi_pinjam' => $alat->kondisi,
                    'status' => 'dipinjam',
                ]);

                $alat->update([
                    'status' => 'dipinjam',
                ]);
            }
        });

        return redirect()
            ->route('transaksi.peminjaman.index')
            ->with('success', 'Peminjaman alat berhasil disimpan.');
    }

    public function show(Peminjaman $peminjaman)
    {
        return redirect()->route('transaksi.peminjaman.index');
    }
}
