<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@donation.com',
            'password' => bcrypt('password'),
            'balance' => 0,
            'role' => 'admin'
        ]);

        // Create sample donatur users
        User::factory()->count(10)->create();

        // Create sample campaigns
        Campaign::create([
            'judul' => 'Bantuan Pendidikan Anak Yatim',
            'deskripsi' => 'Mari bersama-sama membantu pendidikan anak-anak yatim untuk masa depan yang lebih cerah. Donasi Anda akan digunakan untuk biaya sekolah, buku, dan perlengkapan belajar.',
            'kategori' => 'Pendidikan',
            'target_donasi' => 50000000,
            'total_terkumpul' => 15000000,
            'tanggal_berakhir' => now()->addMonths(3),
            'status' => 'aktif'
        ]);

        Campaign::create([
            'judul' => 'Bantuan Korban Bencana Alam',
            'deskripsi' => 'Bantuan untuk korban bencana alam yang membutuhkan tempat tinggal, makanan, dan pakaian layak. Mari berbagi dengan sesama.',
            'kategori' => 'Bencana',
            'target_donasi' => 100000000,
            'total_terkumpul' => 35000000,
            'tanggal_berakhir' => now()->addMonths(2),
            'status' => 'aktif'
        ]);

        Campaign::create([
            'judul' => 'Pengobatan Gratis untuk Dhuafa',
            'deskripsi' => 'Program pengobatan gratis untuk masyarakat kurang mampu. Setiap donasi akan membantu biaya pengobatan dan obat-obatan.',
            'kategori' => 'Kesehatan',
            'target_donasi' => 75000000,
            'total_terkumpul' => 25000000,
            'tanggal_berakhir' => now()->addMonths(4),
            'status' => 'aktif'
        ]);

        Campaign::create([
            'judul' => 'Pembangunan Masjid Kampung',
            'deskripsi' => 'Bantuan untuk pembangunan masjid di kampung terpencil agar masyarakat memiliki tempat ibadah yang layak.',
            'kategori' => 'Sosial',
            'target_donasi' => 200000000,
            'total_terkumpul' => 80000000,
            'tanggal_berakhir' => now()->addMonths(6),
            'status' => 'aktif'
        ]);

        Campaign::create([
            'judul' => 'Beasiswa untuk Anak Berprestasi',
            'deskripsi' => 'Program beasiswa untuk anak-anak berprestasi dari keluarga kurang mampu untuk melanjutkan pendidikan ke jenjang yang lebih tinggi.',
            'kategori' => 'Pendidikan',
            'target_donasi' => 30000000,
            'total_terkumpul' => 30000000,
            'tanggal_berakhir' => now()->subDays(10),
            'status' => 'selesai'
        ]);
    }
}
