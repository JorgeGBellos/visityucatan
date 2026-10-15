<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        District::query()->updateOrCreate(
            ['slug' => 'siglo-xxi'],
            [
                'title_es' => 'Distrito Norte',
                'title_en' => 'Norte District',
                'image' => 'images/home/section6/distrito-siglo.png',
                'href' => '/distrito/siglo-xxi',
                'sort_order' => 1,
                'is_published' => true,
            ],
        );

        District::query()->updateOrCreate(
            ['slug' => 'cic'],
            [
                'title_es' => 'Distrito Centro',
                'title_en' => 'Centro District',
                'image' => 'images/home/section6/distrito-cic.png',
                'href' => '/distrito/cic',
                'sort_order' => 2,
                'is_published' => true,
            ],
        );
    }
}
