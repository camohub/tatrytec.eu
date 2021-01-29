@extends('layout-full')

@section('content')

<div class="row">

	<div class="col-xs-12 ncol-sm-offset-1 col-sm-5">
		<h2 class="p0">Články</h2>
		<ul class="pL30 pV20">
			<li><a href="{{route('admin.articles.create')}}">Vytvoriť nový článok</a></li>
			<li><a href="{{route('admin.articles')}}">Editovať články</a></li>
		</ul>

		<h2 class="p0">Menu</h2>
		<ul class="pL30 pV20">
			<li><a href="{{route('admin.categories')}}">Spravovať menu</a></li>
		</ul>

		<h2 class="p0">Obrázky</h2>
		<ul class="pL30 pV20">
			<li><a href="{{route('admin.images')}}">Blog</a></li>
		</ul>
	</div>

	<div class="col-xs-12 col-sm-5">
		<h2 class="p0">Užívatelia</h2>
		<ul class="pL30 pV20">
			<li><a href="{{route('admin.users')}}">Editovať užívateľov</a></li>
		</ul>

		<h2 class="p0">Drom</h2>
		<ul class="pL30 pV20">
			<li><a href="{{route('admin.drom')}}">Drom</a></li>
		</ul>
	</div>

</div>

@endsection