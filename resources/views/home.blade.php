@extends('base')

@php /** @var App\Data\Components\GridData $gridData */ @endphp

@section('content')
    <x-grid-component :gridData="$gridData" />
@endsection
