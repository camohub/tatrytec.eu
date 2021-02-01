@extends('layout-admin')

@section('content')

<form action="{{$article ? route('admin.articles.store', ['id' => $article->id]) : route('admin.articles.store')}}">
	@csrf

	<h1>{{$article->title ?? 'Vytvoriť článok'}}</h1>

	<div class="form-group">
		@include('components.form-errors')
	</div>

	<div class="form-group">
		<label for="meta_desc">Meta desc</label> <span class="fa fa-question-circle" title="Dôležité z hľadiska SEO. Vyplňte jednou výstižnou vetou a použite kľúčové slová."> </span>
		<input name="meta_desc" value="{{old('meta_desc') ?? $article->meta_desc ?? ''}}" id="meta_desc" type="text" class="form-control">
	</div>

	<div class="form-group">
		<label for="title">Nadpis</label> <span class="fa fa-question-circle" title="Nadpis článku. Použite kľúčové slová."> </span>
		<input name="title" value="{{old('title') ?? $article->title ?? ''}}" id="title" type="text" class="form-control">
	</div>

	<div class="form-group">
		<label for="perex">Perex</label> <span class="fa fa-question-circle" title="Úvod do textu. Zobrazí sa pred textom a ako skrátený text. Používajte kľúčové slová.
Kód a zoznamy sa ukončujú stlačením Shift + Enter"> <!-- Odriadkovanie v title zachovat!!! --></span>
		<textarea name="perex" id="perex" type="text" class="form-control tinymce">{{old('perex') ?? $article->perex ?? ''}}</textarea>
	</div>

	<div class="form-group">
		<label for="content">Text</label> <span class="fa fa-question-circle" title="Používajte kľúčové slová. Najmä v nadpisoch a zvýraznených výrazoch.
Kód a zoznamy sa ukončujú stlačením Shift + Enter"> <!-- Odriadkovanie v title zachovat!!! --></span>
		<textarea name="content" id="content" type="text" class="form-control tinymce" rows="20">{{old('content') ?? $article->content ?? ''}}</textarea>
	</div>

	<div class="form-group">
		<label for="categories">Kategórie</label>
		<select name="categories[]" id="categories" multiple class="form-control" size="7">
			@php
				if( old('categories') ) $articleCategories = collect(old('categories'));
				elseif ( $article ) $articleCategories = $article->categories->map(function($item, $key) { return $item->id; });
				else $articleCategories = collect();
			@endphp
			@foreach($selectCategories as $id => $name)
				<option value="{{$id}}" @if( $articleCategories->contains($id) ) selected @endif>{{$name}}</option>
			@endforeach
		</select>
	</div>

	<div class="form-check mb-3">
		<input name="visible" value="1" @if( old('visible') || !empty($article->visible) ) checked @endif id="visible" type="checkbox" class="form-check-input">
		<label for="visible" class="form-check-label">Aktívny</label>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" value="Uložiť">
	</div>

</form>

@endsection

@section('scripts')
	<script src="https://cdn.tiny.cloud/1/{{config('view.tinymce_token')}}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection