<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $totalAlat = Alat::count();

        $alatTersedia = Alat::where('status', 'tersedia')
            ->whereIn('kondisi', ['baik', 'perlu_perhatian'])
            ->count();
        $alatDipinjam = Alat::where('status', 'dipinjam')
            ->count();
        $alatRusak = Alat::where('kondisi', 'rusak')
            ->count();
        $peminjamanAktif = Peminjaman::with([
            'teknisi',
            'alat'
        ])
            ->where('status', 'dipinjam')
            ->orderBy('waktu_pinjam', 'asc')
            ->limit(10)
            ->get()
            ->sortBy(function ($item) {
                return $item->teknisi->nama_teknisi . '_' . $item->waktu_pinjam;
            });

        $transaksiTerbaru = Peminjaman::with([
            'teknisi',
            'alat'
        ])
            ->latest()
            ->limit(8)
            ->get();

        $semuaAlat = Alat::orderBy('nama_alat')->limit(10)->get();

        return view('dashboard.dashboard_admin', compact(
            'totalAlat',
            'alatTersedia',
            'alatDipinjam',
            'alatRusak',
            'peminjamanAktif',
            'transaksiTerbaru',
            'semuaAlat'
        ));
    }
}
