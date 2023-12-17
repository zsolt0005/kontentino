@extends('base')

@php /** @var \App\View\Components\Data\GridData $gridData */ @endphp

@section('content')
    <x-grid-component :gridData="$gridData"/>
@endsection
