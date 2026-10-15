<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'programacion@madeby.partners'],
            [
                'name' => 'Programación',
                'password' => 'password',
            ],
        );

        $this->call([
            PageContentSeeder::class,
            SiteSettingSeeder::class,
            DistrictSeeder::class,
            DirectoryFilterSeeder::class,
            DistrictPlaceSeeder::class,
            AllySeeder::class,
            BlogPostSeeder::class,
            EventSeeder::class,
        ]);
    }
}
