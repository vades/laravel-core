@extends('errors.layout')
@section('title',  __('app.error.404.title'))
@section('code', '404')
@section('content')
    <p class="mb-8 mt-8">{{__('app.error.404.message')}}</p>
    <a class="button" href="{{ url('/') }}">{{__('app.nav.takeMeHome')}}</a>
@endsection