<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Teknisi;
use Illuminate\Http\Request;

class DataTeknisiController extends Controller
{
    public function index(Request $request)
    {
        $query = Teknisi::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_teknisi', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $teknisis = $query->latest()->paginate(10)->withQueryString();

        return view('masterdata.data_teknisi', compact('teknisis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_teknisi' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ], [
            'nama_teknisi.required' => 'Nama teknisi wajib diisi.',
            'nama_teknisi.max' => 'Nama teknisi maksimal 255 karakter.',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter.',
        ]);

        Teknisi::create($validated);

        return redirect()
            ->route('masterdata.teknisi.index')
            ->with('success', 'Data teknisi berhasil ditambahkan.');
    }

    public function update(Request $request, Teknisi $teknisi)
    {
        $validated = $request->validate([
            'nama_teknisi' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ], [
            'nama_teknisi.required' => 'Nama teknisi wajib diisi.',
            'nama_teknisi.max' => 'Nama teknisi maksimal 255 karakter.',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter.',
        ]);

        $teknisi->update($validated);

        return redirect()
            ->route('masterdata.teknisi.index')
            ->with('success', 'Data teknisi berhasil diperbarui.');
    }

    public function destroy(Teknisi $teknisi)
    {
        if ($teknisi->peminjaman()->exists()) {
            return redirect()
                ->route('masterdata.teknisi.index')
                ->with('error', 'Teknisi tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $teknisi->delete();

        return redirect()
            ->route('masterdata.teknisi.index')
            ->with('success', 'Data teknisi berhasil dihapus.');
    }
}
