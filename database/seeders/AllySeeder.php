<?php

namespace Database\Seeders;

use App\Models\Ally;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AllySeeder extends Seeder
{
    public function run(): void
    {
        $allies = [
            [
                'title_es' => 'Adventures Mexico',
                'title_en' => 'Adventures Mexico',
                'description_es' => 'Expertos en tours especializados para grupos que viajan a México.',
                'description_en' => 'Experts in specialized tours for groups traveling to Mexico.',
                'phone' => '(999) 925 1700',
                'website_url' => 'https://adventures-mexico.com',
                'image' => 'images/home/aliados/adventures-mexico.png',
                'category' => 'DMC',
                'sort_order' => 10,
            ],
            [
                'title_es' => 'Amigo Yucatán',
                'title_en' => 'Amigo Yucatán',
                'description_es' => 'Expertos en eventos y turismo dedicados a transformar tus ideas en momentos.',
                'description_en' => 'Experts in events and tourism dedicated to turning your ideas into moments.',
                'phone' => '(999) 920 0105',
                'website_url' => 'https://amigoyucatan.com',
                'image' => 'images/home/aliados/amigo-yucatan.png',
                'category' => 'Meeting planner & DMC',
                'sort_order' => 20,
            ],
            [
                'title_es' => 'Controltur',
                'title_en' => 'Controltur',
                'description_es' => 'Desarrollador de eventos, desde el concepto hasta el regreso seguro de los participantes.',
                'description_en' => 'Event developers, from concept to the safe return of participants.',
                'phone' => '(999) 949 4614',
                'website_url' => 'https://funky.company',
                'image' => 'images/home/aliados/controltur.png',
                'category' => 'DMC',
                'sort_order' => 30,
            ],
            [
                'title_es' => 'KGroup Wellbeing Meetings',
                'title_en' => 'KGroup Wellbeing Meetings',
                'description_es' => 'Servicio en planeación, desarrollo y operación de eventos.',
                'description_en' => 'Planning, development, and operation services for events.',
                'phone' => '(999) 944 6511',
                'website_url' => 'https://kgroup.com.mx',
                'image' => 'images/home/aliados/kgroup.png',
                'category' => 'Meeting planner & DMC',
                'sort_order' => 40,
            ],
            [
                'title_es' => "Ko'ox DMC & Tour Operator",
                'title_en' => "Ko'ox DMC & Tour Operator",
                'description_es' => 'Equipo especializado en la gestión de eventos, congresos, convenciones, etc.',
                'description_en' => 'A specialized team in managing events, congresses, conventions, and more.',
                'phone' => '(999) 276 1375',
                'website_url' => 'https://kooxdmc.com',
                'image' => 'images/home/aliados/koox.png',
                'category' => 'DMC',
                'sort_order' => 50,
            ],
            [
                'title_es' => 'Luna Maya',
                'title_en' => 'Luna Maya',
                'description_es' => 'Agencia encargada de organización de congresos, convenciones etc.',
                'description_en' => 'An agency dedicated to organizing congresses, conventions, and more.',
                'phone' => '+ 52 (999) 150 0736',
                'website_url' => 'https://lunamayadmc.com',
                'image' => 'images/home/aliados/luna-maya.png',
                'category' => 'DMC',
                'sort_order' => 60,
            ],
            [
                'title_es' => 'Maelca',
                'title_en' => 'Maelca',
                'description_es' => 'Asesoría estratégica, negociación y gestión operativa de eventos.',
                'description_en' => 'Strategic consulting, negotiation, and operational management of events.',
                'phone' => '+ 52 (999) 241 7876',
                'website_url' => 'https://maelca.com.mx',
                'image' => 'images/home/aliados/maelca.png',
                'category' => 'Meeting planner & DMC',
                'sort_order' => 70,
            ],
            [
                'title_es' => 'Meet Mérida',
                'title_en' => 'Meet Mérida',
                'description_es' => 'Operador de congresos, convenciones y viajes de incentivo.',
                'description_en' => 'Operator of congresses, conventions, and incentive travel.',
                'phone' => '+ 52 (999) 477 6537',
                'website_url' => 'https://meetmerida.com',
                'image' => 'images/home/aliados/meet-merida.png',
                'category' => 'DMC',
                'sort_order' => 80,
            ],
            [
                'title_es' => 'Mérida Tour e Incentivos',
                'title_en' => 'Mérida Tour e Incentivos',
                'description_es' => 'Expertos en turismo internacional y nacional del más alto nivel.',
                'description_en' => 'Experts in international and domestic tourism at the highest level.',
                'phone' => '(999) 150 0736',
                'website_url' => 'https://meridatours.com.mx',
                'image' => 'images/home/aliados/merida-tours.png',
                'category' => 'Tour operator',
                'sort_order' => 90,
            ],
            [
                'title_es' => 'Meximeetings',
                'title_en' => 'Meximeetings',
                'description_es' => 'Diseño, planeación y ejecución de eventos y tours para grupos.',
                'description_en' => 'Design, planning, and execution of events and group tours.',
                'phone' => '(999) 960 0830',
                'website_url' => 'https://meximeetings.mx',
                'image' => 'images/home/aliados/meximeetings.png',
                'category' => 'Meeting planner & DMC',
                'sort_order' => 100,
            ],
        ];

        Ally::query()->delete();

        foreach ($allies as $index => $ally) {
            Ally::query()->create([
                ...$ally,
                'location' => 'Mérida, Yucatán',
                'is_published' => true,
                'created_at' => Carbon::now()->subDays($index),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
