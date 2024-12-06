@extends('docs.swagger-page-template')


@section('title')
User API Preview
@endsection

@section('open-api')
@php
    include base_path('docs/api/user-api.json');
@endphp
@endsection