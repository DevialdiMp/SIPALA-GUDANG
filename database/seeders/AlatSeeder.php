<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alat;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $dataAlat = [
            [
                'kode' => 'KKM-001',
                'nama_alat' => 'Kunci Khusus Mesin',
                'kondisi' => 'baik',
                'status' => 'tersedia',
            ],
            [
                'kode' => 'KKM-002',
                'nama_alat' => 'Kunci Khusus Mesin',
                'kondisi' => 'perlu_perhatian',
                'status' => 'tersedia',
            ],
            [
                'kode' => 'OBL-001',
                'nama_alat' => 'Obeng Listrik',
                'kondisi' => 'baik',
                'status' => 'tersedia',
            ],
            [
                'kode' => 'OBL-002',
                'nama_alat' => 'Obeng Listrik',
                'kondisi' => 'perlu_perhatian',
                'status' => 'tersedia',
            ],
            [
                'kode' => 'BOR-001',
                'nama_alat' => 'Bor Listrik',
                'kondisi' => 'baik',
                'status' => 'tersedia',
            ],
            [
                'kode' => 'BOR-002',
                'nama_alat' => 'Bor Listrik',
                'kondisi' => 'rusak',
                'status' => 'pemeliharaan', // atau 'tersedia' sesuai sistem Anda
            ],
            [
                'kode' => 'MLT-001',
                'nama_alat' => 'Multimeter Digital',
                'kondisi' => 'baik',
                'status' => 'tersedia',
            ],
            [
                'kode' => 'MLT-002',
                'nama_alat' => 'Multimeter Digital',
                'kondisi' => 'rusak',
                'status' => 'pemeliharaan', // atau 'tersedia'
            ],
            [
                'kode' => 'JGS-001',
                'nama_alat' => 'Jangka Sorong',
                'kondisi' => 'baik',
                'status' => 'tersedia',
            ],
            [
                'kode' => 'JGS-002',
                'nama_alat' => 'Jangka Sorong',
                'kondisi' => 'perlu_perhatian',
                'status' => 'tersedia',
            ],
        ];

        foreach ($dataAlat as $item) {
            Alat::updateOrCreate(
                ['kode' => $item['kode']],
                [
                    'nama_alat' => $item['nama_alat'],
                    'kondisi' => $item['kondisi'],
                    'status' => $item['status'],
                ]
            );
        }
    }
}
