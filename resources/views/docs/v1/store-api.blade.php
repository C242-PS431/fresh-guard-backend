@extends('docs.swagger-page-template')


@section('title')
Store Data API Preview
@endsection

@section('open-api')
@php
    include base_path('docs/api/store-api.json');
@endphp
@endsection