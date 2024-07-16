@extends('layouts.app', ['page' => __('Tables'), 'pageSlug' => 'weblog'])

@section('content')
@include('layouts.headers.cards')
<weblog-component/>

@endsection