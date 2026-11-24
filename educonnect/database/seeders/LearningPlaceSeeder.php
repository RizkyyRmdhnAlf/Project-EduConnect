<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningPlace;

class LearningPlaceSeeder extends Seeder
{
    public function run(): void
    {
        $places = [
            [
                'name' => 'Rumah Belajar Ceria',
                'category' => 'Bimbingan Belajar',
                'address' => 'Paal Merah, Kota Jambi',
                'description' => 'Tempat belajar bersama untuk membantu meningkatkan kemampuan akademik pelajar.',
            ],
            [
                'name' => 'Pusat Kegiatan Belajar Mandiri',
                'category' => 'Pendidikan Nonformal',
                'address' => 'Jelutung, Kota Jambi',
                'description' => 'Tempat kegiatan belajar untuk masyarakat yang membutuhkan akses pendidikan alternatif.',
            ],
            [
                'name' => 'Komunitas Belajar Digital',
                'category' => 'Komunitas Belajar',
                'address' => 'Kota Baru, Kota Jambi',
                'description' => 'Komunitas belajar yang berfokus pada pengembangan keterampilan digital.',
            ],
        ];

        foreach ($places as $place) {
            LearningPlace::updateOrCreate(
                ['name' => $place['name']],
                $place
            );
        }
    }
}
