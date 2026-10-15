<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\DistrictPlace;
use Illuminate\View\View;

class DistrictController extends Controller
{
    public function show(District $district): View
    {
        abort_unless($district->is_published, 404);

        $cms = cms_page($district->pageKey());
        $lang = $district->langKey();

        $tabLabels = [
            'hotels' => __('site.distrito_directory.tabs.hotels'),
            'venues' => __('site.distrito_directory.tabs.venues'),
        ];

        $spaces = DistrictPlace::query()
            ->published()
            ->forDistrict($district)
            ->ordered()
            ->get()
            ->map(fn (DistrictPlace $place) => $place->toDirectoryItem())
            ->values()
            ->all();

        $presentCategories = collect($spaces)->pluck('category')->unique()->filter()->all();
        $tabs = collect($tabLabels)
            ->only($presentCategories !== [] ? $presentCategories : array_keys($tabLabels))
            ->all();

        return view('pages.distrito', [
            'district' => $district,
            'cms' => $cms,
            'lang' => $lang,
            'title' => $cms->text('hero.title', $lang.'.title'),
            'subtitle' => $cms->text('hero.subtitle', $lang.'.subtitle'),
            'bannerTitle' => $cms->text('banner.title', $lang.'.banner_title'),
            'introHeadline' => $cms->text('intro.headline', $lang.'.intro_headline'),
            'introTextBefore' => $cms->text('intro.text_before', $lang.'.intro_text_before'),
            'introTextBold' => $cms->text('intro.text_bold', $lang.'.intro_text_bold'),
            'introTextAfter' => $cms->text('intro.text_after', $lang.'.intro_text_after'),
            'cta' => $cms->text('intro.cta', $lang.'.cta'),
            'ctaUrl' => $cms->text('intro.cta_url', $lang.'.cta_url'),
            'bannerVideo' => match ($district->slug) {
                'siglo-xxi' => 'videos/distrito-siglo-xxi.mov',
                default => 'videos/distrito-cic.mov',
            },
            'tabs' => $tabs,
            'spaces' => $spaces,
        ]);
    }
}
