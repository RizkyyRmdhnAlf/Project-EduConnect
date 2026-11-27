<?php

namespace Database\Seeders;

use App\Models\NeedCategory;
use Illuminate\Database\Seeder;

class NeedCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Buku',
            'Alat Tulis',
            'Fasilitas',
            'Internet',
            'Bimbingan Belajar',
            'Lainnya',
        ] as $name) {
            NeedCategory::query()->firstOrCreate(['name' => $name]);
        }
    }
}
