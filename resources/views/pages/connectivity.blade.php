@extends('layouts.site')

@section('title', __('site.connectivity_page.title').' — '.config('app.name'))

@section('content')
    <x-content-page
        :eyebrow="__('site.connectivity_page.eyebrow')"
        :title="__('site.connectivity_page.title')"
        :intro="__('site.connectivity_page.intro')"
        :sections="__('site.connectivity_page.sections')"
    />
@endsection
