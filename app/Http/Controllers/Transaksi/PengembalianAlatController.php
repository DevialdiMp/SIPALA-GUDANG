<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PengembalianAlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['teknisi', 'alat'])
            ->where('status', 'dikembalikan')
            ->latest('waktu_kembali');

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

        $pengembalian = $query->paginate(2)->withQueryString();

        $peminjamanAktif = Peminjaman::with(['teknisi', 'alat'])
            ->where('status', 'dipinjam')
            ->orderBy('waktu_pinjam')
            ->get();

        $mode = 'index';

        return view('transaksi.pengembalian_alat', compact(
            'pengembalian',
            'peminjamanAktif',
            'mode'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => [
                'required',
                'exists:peminjaman,id',
            ],
            'kondisi_kembali' => [
                'required',
                'in:baik,perlu_perhatian,rusak',
            ],
            'catatan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'peminjaman_id.required' => 'Transaksi peminjaman tidak ditemukan.',
            'kondisi_kembali.required' => 'Silakan pilih kondisi alat.',
            'kondisi_kembali.in' => 'Kondisi alat tidak valid.',
        ]);

        DB::transaction(function () use ($validated) {
            $peminjaman = Peminjaman::whereKey(
                $validated['peminjaman_id']
            )->lockForUpdate()->firstOrFail();

            if ($peminjaman->status !== 'dipinjam') {
                throw ValidationException::withMessages([
                    'peminjaman_id' => 'Alat ini sudah dikembalikan.',
                ]);
            }

            $alat = Alat::whereKey($peminjaman->alat_id)
                ->lockForUpdate()
                ->firstOrFail();

            $peminjaman->update([
                'waktu_kembali' => now(),
                'kondisi_kembali' => $validated['kondisi_kembali'],
                'catatan' => $validated['catatan'] ?? null,
                'status' => 'dikembalikan',
            ]);

            $alat->update([
                'kondisi' => $validated['kondisi_kembali'],
                'status' => 'tersedia',
            ]);
        });

        return redirect()
            ->route('transaksi.pengembalian.index')
            ->with('success', 'Pengembalian alat berhasil disimpan.');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['teknisi', 'alat']);

        if ($peminjaman->status !== 'dikembalikan') {
            abort(404);
        }

        $peminjamanAktif = collect();
        $mode = 'show';

        return view('transaksi.pengembalian_alat', compact(
            'pengembalian',
            'peminjamanAktif',
            'mode'
        ));
    }
}
