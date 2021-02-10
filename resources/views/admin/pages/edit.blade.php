@extends('layout-admin')

@section('content')

<form action="{{$page ? route('admin.pages.store', ['id' => $page->id]) : route('admin.pages.store')}}" method="post">
	@csrf

	<h1>{{$page->title ?? 'Vytvoriť stránku'}}</h1>

	<div class="form-group">
		@include('components.form-errors')
	</div>

	<div class="form-group">
		<label for="title">Nadpis</label> <span class="fa fa-question-circle" title="Nadpis článku. Použite kľúčové slová."> </span>
		<input name="title" value="{{old('title') ?? $page->title ?? ''}}" id="title" type="text" class="form-control">
	</div>

	<div class="form-group">
		<label for="content">Text</label> <span class="fa fa-question-circle" title="Používajte kľúčové slová. Najmä v nadpisoch a zvýraznených výrazoch.
Kód a zoznamy sa ukončujú stlačením Shift + Enter"> <!-- Odriadkovanie v title zachovat!!! --></span>
		<textarea name="content" id="content" type="text" class="form-control tinymce" rows="20">{{old('content') ?? $page->content ?? ''}}</textarea>
	</div>

	<div class="form-check mb-3">
		<input name="visible" value="1" @if( old('visible') || !empty($page->visible) ) checked @endif id="visible" type="checkbox" class="form-check-input">
		<label for="visible" class="form-check-label">Aktívny</label>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" value="Uložiť">
	</div>

	<script src="https://cdn.tiny.cloud/1/{{config('view.tinymce_token')}}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

</form>

@endsection