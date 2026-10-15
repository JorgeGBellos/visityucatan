<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::query()->delete();

        $events = [
            [
                'title_es' => 'FLII 2026',
                'title_en' => 'FLII 2026',
                'slug' => 'flii-2026',
                'category_es' => 'Congresos',
                'category_en' => 'Congresses',
                'date_label_es' => 'Del 24 al 26 de Febrero',
                'date_label_en' => 'February 24–26',
                'location_es' => 'Siglo XXI',
                'location_en' => 'Siglo XXI',
                'image' => 'images/eventos/flii-2026.png',
                'starts_at' => '2026-02-24',
            ],
            [
                'title_es' => '37º Congreso Internacional de Medicina de Urgencia y Reanimación',
                'title_en' => '37th International Congress of Emergency Medicine and Resuscitation',
                'slug' => 'cimu-2026',
                'category_es' => 'Congresos',
                'category_en' => 'Congresses',
                'date_label_es' => 'Del 17 al 20 Febrero 2026',
                'date_label_en' => 'February 17–20, 2026',
                'location_es' => 'CIC',
                'location_en' => 'CIC',
                'image' => 'images/eventos/cimu-2026.png',
                'starts_at' => '2026-02-17',
            ],
            [
                'title_es' => 'CODEMAR Copa Deportiva Marista',
                'title_en' => 'CODEMAR Marist Sports Cup',
                'slug' => 'codemar-2026',
                'category_es' => 'Eventos deportivos',
                'category_en' => 'Sports events',
                'date_label_es' => 'Del 12 y 13 Marzo 2026',
                'date_label_en' => 'March 12–13, 2026',
                'location_es' => 'Centro Universitario Montejo',
                'location_en' => 'Centro Universitario Montejo',
                'image' => 'images/eventos/codemar-2026.png',
                'starts_at' => '2026-03-12',
            ],
            [
                'title_es' => 'CVDERM Congreso Veterinario de Dermatología',
                'title_en' => 'CVDERM Veterinary Dermatology Congress',
                'slug' => 'cvderm-2026',
                'category_es' => 'Congresos',
                'category_en' => 'Congresses',
                'date_label_es' => 'Del 04 al 06 Marzo 2026',
                'date_label_en' => 'March 4–6, 2026',
                'location_es' => 'CIC',
                'location_en' => 'CIC',
                'image' => 'images/eventos/cvderm-2026.png',
                'starts_at' => '2026-03-04',
            ],
            [
                'title_es' => 'Congreso Internacional de Arquitectura de la (UIA) 2026',
                'title_en' => 'International Architecture Congress (UIA) 2026',
                'slug' => 'fcarm-2026',
                'category_es' => 'Congresos',
                'category_en' => 'Congresses',
                'date_label_es' => 'El 12 y 13 Marzo 2026',
                'date_label_en' => 'March 12–13, 2026',
                'location_es' => 'Gran Museo del Mundo Maya',
                'location_en' => 'Gran Museo del Mundo Maya',
                'image' => 'images/eventos/fcarm-2026.png',
                'starts_at' => '2026-03-12',
            ],
            [
                'title_es' => 'Convención REVOLT',
                'title_en' => 'REVOLT Convention',
                'slug' => 'revolt-2026',
                'category_es' => 'Convenciones',
                'category_en' => 'Conventions',
                'date_label_es' => 'Del 13 al 15 Marzo 2026',
                'date_label_en' => 'March 13–15, 2026',
                'location_es' => 'CIC',
                'location_en' => 'CIC',
                'image' => 'images/eventos/revolt-2026.png',
                'starts_at' => '2026-03-13',
            ],
            [
                'title_es' => 'Giro Copa del Mundo FIFA 2026',
                'title_en' => 'FIFA World Cup 2026 Trophy Tour',
                'slug' => 'fifa-trophy-tour-2026',
                'category_es' => 'Eventos deportivos',
                'category_en' => 'Sports events',
                'date_label_es' => 'El 21 y 22 Marzo 2026',
                'date_label_en' => 'March 21–22, 2026',
                'location_es' => 'CIC',
                'location_en' => 'CIC',
                'image' => 'images/eventos/fifa-trophy-tour-2026.png',
                'starts_at' => '2026-03-21',
            ],
            [
                'title_es' => 'Congreso Internacional en Educación Divergente y Congreso Iberoamericano',
                'title_en' => 'International Congress on Divergent Education and Ibero-American Congress',
                'slug' => 'cice-2026',
                'category_es' => 'Exposiciones',
                'category_en' => 'Exhibitions',
                'date_label_es' => 'El 26 y 28 Marzo 2026',
                'date_label_en' => 'March 26–30, 2026',
                'location_es' => 'Siglo XXI',
                'location_en' => 'Siglo XXI',
                'image' => 'images/eventos/cice-2026.png',
                'starts_at' => '2026-03-26',
            ],
        ];

        foreach ($events as $index => $event) {
            Event::query()->create([
                ...$event,
                'starts_at' => Carbon::parse($event['starts_at'])->toDateString(),
                'sort_order' => $index + 1,
                'is_published' => true,
            ]);
        }
    }
}
