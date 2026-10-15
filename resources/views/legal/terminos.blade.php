@extends('layouts.site')

@section('title', __('site.legal.terms.title').' — '.config('app.name'))

@section('content')
    <x-legal-page
        :eyebrow="__('site.legal.eyebrow')"
        :title="__('site.legal.terms.title')"
        :updated="__('site.legal.terms.updated')"
        :intro="__('site.legal.terms.intro')"
        :sections="__('site.legal.terms.sections')"
    />
@endsection
