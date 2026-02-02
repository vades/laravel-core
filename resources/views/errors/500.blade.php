@extends('errors.layout')
@section('title', __('app.error.500.title'))
@section('code', '500')
@section('content')
    <p class="mb-8 mt-8"> {{__('app.error.500.message')}}</p>
@endsection