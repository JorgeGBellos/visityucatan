<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\DistrictPlace;
use Illuminate\Database\Seeder;

class DistrictPlaceSeeder extends Seeder
{
    /**
     * @var list<array{
     *     title_es: string,
     *     title_en: string,
     *     phone: string,
     *     website: string,
     *     website_url: string|null,
     *     email: string,
     *     image: string
     * }>
     */
    protected array $cicHaciendas = [
        [
            'title_es' => 'San Diego Cutz',
            'title_en' => 'San Diego Cutz',
            'phone' => '(999) 408 5207',
            'website' => 'haciendasandiegocutz.com',
            'website_url' => 'https://haciendasandiegocutz.com',
            'email' => 'info@haciendasandiegocutz.com',
            'image' => 'images/distritos/centro/san-diego-cutz.png',
        ],
        [
            'title_es' => 'Xtepén',
            'title_en' => 'Xtepén',
            'phone' => '(999) 455 9920',
            'website' => 'haciendaxtepen.com',
            'website_url' => 'https://haciendaxtepen.com',
            'email' => 'info@haciendaxtepen.com',
            'image' => 'images/distritos/centro/xtepen.png',
        ],
        [
            'title_es' => 'Dizibkak',
            'title_en' => 'Dizibkak',
            'phone' => '(999) 245 6572 / (999) 177 7702',
            'website' => 'haciendadizibkak.com',
            'website_url' => 'https://haciendadizibkak.com',
            'email' => 'info@haciendadizibkak.com',
            'image' => 'images/distritos/centro/dizibkak.png',
        ],
        [
            'title_es' => 'San Antonio Hool',
            'title_en' => 'San Antonio Hool',
            'phone' => '(999) 550 2762',
            'website' => 'sanantoniohool.com',
            'website_url' => 'https://sanantoniohool.com',
            'email' => 'info@sanantoniohool.com',
            'image' => 'images/distritos/centro/san-antonio-hool.png',
        ],
        [
            'title_es' => 'Uxmal',
            'title_en' => 'Uxmal',
            'phone' => '(997) 123 2707',
            'website' => 'Página web',
            'website_url' => null,
            'email' => 'correo',
            'image' => 'images/distritos/centro/uxmal.png',
        ],
        [
            'title_es' => 'Yabucú',
            'title_en' => 'Yabucú',
            'phone' => '(999) 183 2127',
            'website' => 'haciendayabucu.com',
            'website_url' => 'https://haciendayabucu.com',
            'email' => 'reservas@yabucu.mx',
            'image' => 'images/distritos/centro/yabucu.png',
        ],
        [
            'title_es' => 'Yaxcopoil',
            'title_en' => 'Yaxcopoil',
            'phone' => '(999) 900 1193',
            'website' => 'yaxcopoil.com',
            'website_url' => 'https://yaxcopoil.com',
            'email' => 'hacienda@yaxcopoil.com',
            'image' => 'images/distritos/centro/yaxcopoil.png',
        ],
        [
            'title_es' => 'Idelfonso Teya',
            'title_en' => 'Idelfonso Teya',
            'phone' => '(999) 393 5600',
            'website' => 'haciendateya.com',
            'website_url' => 'https://haciendateya.com',
            'email' => 'info@haciendateya.com',
            'image' => 'images/distritos/centro/idelfonso-teya.png',
        ],
        [
            'title_es' => 'San Pedro Ochil',
            'title_en' => 'San Pedro Ochil',
            'phone' => '(999) 000 0000',
            'website' => 'pagina web',
            'website_url' => null,
            'email' => 'correo',
            'image' => 'images/distritos/centro/san-pedro-ochil.png',
        ],
        [
            'title_es' => 'Santa Cruz',
            'title_en' => 'Santa Cruz',
            'phone' => '(999) 611 9233',
            'website' => 'haciendasantacruz.com',
            'website_url' => 'https://haciendasantacruz.com',
            'email' => 'ventas@haciendasantacruz.com',
            'image' => 'images/distritos/centro/santa-cruz.png',
        ],
        [
            'title_es' => 'Xacatún',
            'title_en' => 'Xacatún',
            'phone' => '(999) 437 8861',
            'website' => 'Página web',
            'website_url' => null,
            'email' => 'mayra.hernandez@angsana.com',
            'image' => 'images/distritos/centro/xacatun.png',
        ],
        [
            'title_es' => 'Poxilá',
            'title_en' => 'Poxilá',
            'phone' => '(999) 197 6032',
            'website' => 'Página web',
            'website_url' => null,
            'email' => 'haciendapoxila@gmail.com',
            'image' => 'images/distritos/centro/poxila.png',
        ],
    ];

    /**
     * @var list<array{
     *     title_es: string,
     *     title_en: string,
     *     type: string,
     *     phone: string,
     *     website: string,
     *     website_url: string|null,
     *     email: string,
     *     image: string
     * }>
     */
    protected array $cicVenues = [
        [
            'title_es' => 'El Pinar',
            'title_en' => 'El Pinar',
            'type' => 'museo',
            'phone' => '(999) 380 7710',
            'website' => 'elpinar.com.mx',
            'website_url' => 'https://elpinar.com.mx',
            'email' => 'contacto@elpinar.com.mx',
            'image' => 'images/distritos/centro/venues/el-pinar.png',
        ],
        [
            'title_es' => 'Quinta Monte Molina',
            'title_en' => 'Quinta Monte Molina',
            'type' => 'museo',
            'phone' => '(999) 258 9629',
            'website' => 'laquintamm.com',
            'website_url' => 'https://laquintamm.com',
            'email' => 'direccion@laquintamm.com',
            'image' => 'images/distritos/centro/venues/quinta-monte-molina.png',
        ],
        [
            'title_es' => 'Casa Palomeque',
            'title_en' => 'Casa Palomeque',
            'type' => 'venue',
            'phone' => '(999) 923 4777',
            'website' => 'pagina web',
            'website_url' => null,
            'email' => 'correo',
            'image' => 'images/distritos/centro/venues/casa-palomeque.png',
        ],
        [
            'title_es' => 'Olympo',
            'title_en' => 'Olympo',
            'type' => 'centro_cultural',
            'phone' => '(999) 420 000',
            'website' => 'pagina web',
            'website_url' => null,
            'email' => 'correo',
            'image' => 'images/distritos/centro/venues/olympo.png',
        ],
        [
            'title_es' => 'Casona 333',
            'title_en' => 'Casona 333',
            'type' => 'hacienda',
            'phone' => '(999) 900 3915',
            'website' => 'casona333.mx',
            'website_url' => 'https://casona333.mx',
            'email' => 'correo',
            'image' => 'images/distritos/centro/venues/casona-333.png',
        ],
        [
            'title_es' => 'Armando Manzanero',
            'title_en' => 'Armando Manzanero',
            'type' => 'teatro',
            'phone' => '(999) 924 0040 / (999) 924 9990',
            'website' => 'Página web',
            'website_url' => null,
            'email' => 'correo',
            'image' => 'images/distritos/centro/venues/armando-manzanero.png',
        ],
        [
            'title_es' => 'Universitario',
            'title_en' => 'Universitario',
            'type' => 'centro_cultural',
            'phone' => 'Telefono',
            'website' => 'Página web',
            'website_url' => null,
            'email' => 'Correo',
            'image' => 'images/distritos/centro/venues/universitario.png',
        ],
        [
            'title_es' => 'Palacio de la Música',
            'title_en' => 'Palacio de la Música',
            'type' => 'museo',
            'phone' => '(999) 923 0641',
            'website' => 'Página web',
            'website_url' => null,
            'email' => 'correo',
            'image' => 'images/distritos/centro/venues/palacio-de-la-musica.png',
        ],
        [
            'title_es' => 'Daniel Ayala',
            'title_en' => 'Daniel Ayala',
            'type' => 'teatro',
            'phone' => '(999) 123 2707',
            'website' => 'Página web',
            'website_url' => null,
            'email' => 'correo',
            'image' => 'images/distritos/centro/venues/daniel-ayala.png',
        ],
        [
            'title_es' => 'Universidad Felipe Carrillo Puerto',
            'title_en' => 'Universidad Felipe Carrillo Puerto',
            'type' => 'teatro',
            'phone' => '(999) 930 0900',
            'website' => 'uady.mx',
            'website_url' => 'https://uady.mx',
            'email' => 'correo',
            'image' => 'images/distritos/centro/venues/universidad-felipe-carrillo-puerto.png',
        ],
    ];

    public function run(): void
    {
        $this->call(DirectoryFilterSeeder::class);

        $districts = District::query()
            ->whereIn('slug', ['cic', 'siglo-xxi'])
            ->get()
            ->keyBy('slug');

        if ($districts->isEmpty()) {
            $this->call(DistrictSeeder::class);
            $districts = District::query()
                ->whereIn('slug', ['cic', 'siglo-xxi'])
                ->get()
                ->keyBy('slug');
        }

        $cic = $districts->get('cic');
        $norte = $districts->get('siglo-xxi');

        if ($cic) {
            $this->seedHaciendas($cic, 'centro');
            $this->seedCicVenues($cic);
            DistrictPlace::query()
                ->where('district_id', $cic->id)
                ->whereIn('category', ['restaurants', 'attractions', 'convention_centers', 'events'])
                ->delete();
        }

        if ($norte) {
            $this->seedHaciendas($norte, 'norte');
            DistrictPlace::query()
                ->where('district_id', $norte->id)
                ->whereIn('category', ['venues', 'restaurants', 'attractions', 'convention_centers', 'events'])
                ->delete();
        }
    }

    protected function seedHaciendas(District $district, string $zone): void
    {
        DistrictPlace::query()
            ->where('district_id', $district->id)
            ->where('category', 'hotels')
            ->delete();

        foreach ($this->cicHaciendas as $index => $item) {
            DistrictPlace::query()->create([
                'district_id' => $district->id,
                'category' => 'hotels',
                'title_es' => $item['title_es'],
                'title_en' => $item['title_en'],
                'description_es' => null,
                'description_en' => null,
                'type' => 'hacienda',
                'filter_secondary' => $zone,
                'filter_tertiary' => null,
                'image' => $item['image'],
                'phone' => $item['phone'],
                'website_url' => $item['website_url'] ?: $item['website'],
                'location' => $item['email'],
                'sort_order' => $index + 1,
                'is_published' => true,
            ]);
        }
    }

    protected function seedCicVenues(District $district): void
    {
        DistrictPlace::query()
            ->where('district_id', $district->id)
            ->where('category', 'venues')
            ->delete();

        foreach ($this->cicVenues as $index => $item) {
            DistrictPlace::query()->create([
                'district_id' => $district->id,
                'category' => 'venues',
                'title_es' => $item['title_es'],
                'title_en' => $item['title_en'],
                'description_es' => null,
                'description_en' => null,
                'type' => $item['type'],
                'filter_secondary' => 'centro',
                'filter_tertiary' => null,
                'image' => $item['image'],
                'phone' => $item['phone'],
                'website_url' => $item['website_url'] ?: $item['website'],
                'location' => $item['email'],
                'sort_order' => $index + 1,
                'is_published' => true,
            ]);
        }
    }
}
