@extends('docs.swagger-page-template')


@section('title')
Scan API Preview
@endsection

@section('open-api')
@php
    include base_path('docs/api/scan-api.json');
@endphp
@endsection