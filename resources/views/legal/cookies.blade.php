@extends('layouts.site')

@section('title', __('site.legal.cookies.title').' — '.config('app.name'))

@section('content')
    <x-legal-page
        :eyebrow="__('site.legal.eyebrow')"
        :title="__('site.legal.cookies.title')"
        :updated="__('site.legal.cookies.updated')"
        :intro="__('site.legal.cookies.intro')"
        :sections="__('site.legal.cookies.sections')"
    />
@endsection
