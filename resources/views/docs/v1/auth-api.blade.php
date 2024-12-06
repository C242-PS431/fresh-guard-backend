@extends('docs.swagger-page-template')


@section('title')
Authentication API Preview
@endsection

@section('open-api')
@php
    include base_path('docs/api/auth-api.json');
@endphp
@endsection