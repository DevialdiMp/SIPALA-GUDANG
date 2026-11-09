<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DataAlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Alat::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama_alat', 'like', "%{$search}%");
            });
        }

        if (in_array($request->kondisi, ['baik', 'rusak', 'perlu_perhatian'])) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $alats = $query->latest()->paginate(10)->withQueryString();

        return view('masterdata.data_alat', compact('alats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:255', 'unique:alat,kode'],
            'nama_alat' => ['required', 'string', 'max:255'],
            'kondisi' => ['required', Rule::in(['baik', 'rusak', 'perlu_perhatian'])],
        ], [
            'kode.required' => 'Kode alat wajib diisi.',
            'kode.unique' => 'Kode alat sudah digunakan.',
            'nama_alat.required' => 'Nama alat wajib diisi.',
            'kondisi.required' => 'Kondisi alat wajib dipilih.',
            'kondisi.in' => 'Kondisi alat tidak valid.',
        ]);

        $validated['status'] = 'tersedia';

        Alat::create($validated);

        return redirect()
            ->route('masterdata.alat.index')
            ->with('success', 'Data alat berhasil ditambahkan.');
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:255',
                Rule::unique('alat', 'kode')->ignore($alat->id),
            ],
            'nama_alat' => ['required', 'string', 'max:255'],
            'kondisi' => ['required', Rule::in(['baik', 'rusak', 'perlu_perhatian'])],
        ], [
            'kode.required' => 'Kode alat wajib diisi.',
            'kode.unique' => 'Kode alat sudah digunakan.',
            'nama_alat.required' => 'Nama alat wajib diisi.',
            'kondisi.required' => 'Kondisi alat wajib dipilih.',
            'kondisi.in' => 'Kondisi alat tidak valid.',
        ]);

        $alat->update($validated);

        return redirect()
            ->route('masterdata.alat.index')
            ->with('success', 'Data alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat)
    {
        if ($alat->peminjaman()->exists()) {
            return redirect()
                ->route('masterdata.alat.index')
                ->with('error', 'Alat tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $alat->delete();

        return redirect()
            ->route('masterdata.alat.index')
            ->with('success', 'Data alat berhasil dihapus.');
    }
}
