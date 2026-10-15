<?php

namespace Database\Seeders;

use App\Models\DirectoryFilter;
use Illuminate\Database\Seeder;

class DirectoryFilterSeeder extends Seeder
{
    public function run(): void
    {
        $filters = [
            DirectoryFilter::GROUP_TYPE => [
                ['slug' => 'boutique', 'title_es' => 'Boutique', 'title_en' => 'Boutique', 'sort_order' => 1],
                ['slug' => 'business', 'title_es' => 'Negocios', 'title_en' => 'Business', 'sort_order' => 2],
                ['slug' => 'luxury', 'title_es' => 'Lujo', 'title_en' => 'Luxury', 'sort_order' => 3],
                ['slug' => 'all-inclusive', 'title_es' => 'Todo incluido', 'title_en' => 'All inclusive', 'sort_order' => 4],
            ],
            DirectoryFilter::GROUP_SECONDARY => [
                ['slug' => 'centro', 'title_es' => 'Centro', 'title_en' => 'Downtown', 'sort_order' => 1],
                ['slug' => 'norte', 'title_es' => 'Norte', 'title_en' => 'North', 'sort_order' => 2],
                ['slug' => 'sur', 'title_es' => 'Sur', 'title_en' => 'South', 'sort_order' => 3],
                ['slug' => 'oriente', 'title_es' => 'Oriente', 'title_en' => 'East', 'sort_order' => 4],
            ],
            DirectoryFilter::GROUP_TERTIARY => [
                ['slug' => 'pequena', 'title_es' => 'Pequeña', 'title_en' => 'Small', 'sort_order' => 1],
                ['slug' => 'mediana', 'title_es' => 'Mediana', 'title_en' => 'Medium', 'sort_order' => 2],
                ['slug' => 'grande', 'title_es' => 'Grande', 'title_en' => 'Large', 'sort_order' => 3],
                ['slug' => 'extra-grande', 'title_es' => 'Extra grande', 'title_en' => 'Extra large', 'sort_order' => 4],
            ],
        ];

        foreach ($filters as $group => $items) {
            foreach ($items as $item) {
                DirectoryFilter::query()->updateOrCreate(
                    [
                        'group' => $group,
                        'slug' => $item['slug'],
                    ],
                    [
                        'title_es' => $item['title_es'],
                        'title_en' => $item['title_en'],
                        'sort_order' => $item['sort_order'],
                        'is_published' => true,
                    ],
                );
            }
        }
    }
}
