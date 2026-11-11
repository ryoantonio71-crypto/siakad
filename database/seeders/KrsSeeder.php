<?php

namespace Database\Seeders;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class KrsSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil 10 mahasiswa pertama
        $mahasiswa = Mahasiswa::orderBy('id')
            ->limit(10)
            ->get();

        // Ambil semua mata kuliah
        $mataKuliah = MataKuliah::all();

        // Pastikan tersedia minimal 5 mata kuliah
        if ($mataKuliah->count() < 5) {
            $this->command->error(
                'Minimal harus tersedia 5 mata kuliah.'
            );

            return;
        }

        foreach ($mahasiswa as $mhs) {
            // Buat atau ambil KRS mahasiswa
            $krs = Krs::updateOrCreate(
                [
                    'mahasiswa_id' => $mhs->id,
                    'tahun_akademik' => '2026/2027',
                    'semester' => 'Ganjil',
                ],
                [
                    'status' => 'draft',
                ]
            );

            // Hapus relasi lama agar seeder aman dijalankan ulang
            $krs->matakuliah()->detach();

            // Pilih 5 mata kuliah secara acak
            $pilihan = $mataKuliah
                ->random(5)
                ->pluck('id')
                ->toArray();

            // Hubungkan mata kuliah dengan KRS
            $krs->matakuliah()->attach($pilihan);
        }

        $this->command->info(
            'Seeder KRS berhasil dijalankan.'
        );
    }
}
