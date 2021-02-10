@extends('layout-full')

@section('content')

		<h1>{{$page->title}}</h1>

		<div>{!! $page->content !!}</div>

@endsection