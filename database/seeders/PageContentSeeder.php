<?php

namespace Database\Seeders;

use App\Filament\Pages\ManageAboutPage;
use App\Filament\Pages\ManageApoyosPage;
use App\Filament\Pages\ManageAlliesPage;
use App\Filament\Pages\ManageBlogPage;
use App\Filament\Pages\ManageDistritoCicPage;
use App\Filament\Pages\ManageDistritoSigloPage;
use App\Filament\Pages\ManageDistrictsPage;
use App\Filament\Pages\ManageEventsPage;
use App\Filament\Pages\ManageFideturePage;
use App\Filament\Pages\ManageHomePage;
use App\Filament\Pages\ManageWhyPage;
use App\Models\PageContent;
use App\Support\Cms\Cms;
use Illuminate\Database\Seeder;
use ReflectionClass;

class PageContentSeeder extends Seeder
{
    /**
     * @var list<class-string>
     */
    protected array $pages = [
        ManageHomePage::class,
        ManageAboutPage::class,
        ManageWhyPage::class,
        ManageApoyosPage::class,
        ManageFideturePage::class,
        ManageAlliesPage::class,
        ManageDistrictsPage::class,
        ManageDistritoCicPage::class,
        ManageDistritoSigloPage::class,
        ManageBlogPage::class,
        ManageEventsPage::class,
    ];

    public function run(): void
    {
        foreach ($this->pages as $pageClass) {
            $reflection = new ReflectionClass($pageClass);
            $instance = $reflection->newInstanceWithoutConstructor();
            $method = $reflection->getMethod('localizedDefaults');
            $method->setAccessible(true);

            /** @var array<string, mixed> $defaults */
            $defaults = $method->invoke($instance);
            $key = $pageClass::pageKey();

            PageContent::query()->updateOrCreate(
                ['page_key' => $key],
                [
                    'label' => $reflection->getStaticPropertyValue('title') ?? $key,
                    'cms_enabled' => true,
                    'content' => $defaults,
                ],
            );

            Cms::forget($key);
        }
    }
}
