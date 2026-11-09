<?php

namespace App\Http\Controllers\Riwayat;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class RiwayatAlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['teknisi', 'alat'])
            ->latest('waktu_pinjam');

        if ($request->filled('q')) {
            $keyword = $request->q;

            $query->where(function ($q) use ($keyword) {
                $q->whereHas('teknisi', function ($t) use ($keyword) {
                    $t->where('nama_teknisi', 'like', "%{$keyword}%");
                })
                    ->orWhereHas('alat', function ($a) use ($keyword) {
                        $a->where('nama_alat', 'like', "%{$keyword}%")
                            ->orWhere('kode', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kondisi_kembali')) {
            $query->where(
                'kondisi_kembali',
                $request->kondisi_kembali
            );
        }

        $riwayat = $query->paginate(10)->withQueryString();
        $mode = 'index';

        return view('riwayat.riwayat_alat', compact(
            'riwayat',
            'mode'
        ));
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['teknisi', 'alat']);

        return view('riwayat.riwayat_alat', [
            'riwayat' => $peminjaman,
            'mode' => 'show',
        ]);
    }
}
