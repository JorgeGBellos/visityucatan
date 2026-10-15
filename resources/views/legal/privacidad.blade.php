@extends('layouts.site')

@section('title', __('site.legal.privacy.title').' — '.config('app.name'))

@section('content')
    <x-legal-page
        :eyebrow="__('site.legal.eyebrow')"
        :title="__('site.legal.privacy.title')"
        :updated="__('site.legal.privacy.updated')"
        :intro="__('site.legal.privacy.intro')"
        :sections="__('site.legal.privacy.sections')"
    />
@endsection
