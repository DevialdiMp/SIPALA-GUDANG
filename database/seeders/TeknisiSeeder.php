<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teknisi;

class TeknisiSeeder extends Seeder
{
    public function run(): void
    {
        $dataTeknisi = [
            [
                'nama_teknisi' => 'Andi Saputra',
                'no_hp' => '081234560001',
                'alamat' => 'Pekanbaru',
            ],
            [
                'nama_teknisi' => 'Budi Santoso',
                'no_hp' => '081234560002',
                'alamat' => 'Rumbai',
            ],
            [
                'nama_teknisi' => 'Candra Wijaya',
                'no_hp' => '081234560003',
                'alamat' => 'Marpoyan',
            ],
            [
                'nama_teknisi' => 'Daboyy The King',
                'no_hp' => '081234560004',
                'alamat' => 'Panam',
            ],
            [
                'nama_teknisi' => 'Eko Prasetyo',
                'no_hp' => '081234560005',
                'alamat' => 'Tampan',
            ],
            [
                'nama_teknisi' => 'Fajar Ramadhan',
                'no_hp' => '081234560006',
                'alamat' => 'Tenayan Raya',
            ],
            [
                'nama_teknisi' => 'Gunawan Putra',
                'no_hp' => '081234560007',
                'alamat' => 'Sukajadi',
            ],
            [
                'nama_teknisi' => 'Hendra Saputra',
                'no_hp' => '081234560008',
                'alamat' => 'Senapelan',
            ],
            [
                'nama_teknisi' => 'Irfan Maulana',
                'no_hp' => '081234560009',
                'alamat' => 'Bukit Raya',
            ],
            [
                'nama_teknisi' => 'Joko Susilo',
                'no_hp' => '081234560010',
                'alamat' => 'Payung Sekaki',
            ],
            [
                'nama_teknisi' => 'Rizky Firmansyah',
                'no_hp' => '081234560011',
                'alamat' => 'Lima Puluh',
            ],
            [
                'nama_teknisi' => 'Yoga Pratama',
                'no_hp' => '081234560012',
                'alamat' => 'Kulim',
            ],
        ];

        foreach ($dataTeknisi as $teknisi) {
            Teknisi::updateOrCreate(
                ['nama_teknisi' => $teknisi['nama_teknisi']],
                $teknisi
            );
        }
    }
}
