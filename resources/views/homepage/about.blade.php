@extends('layout-homepage')

@section('content')

	<video autoplay muted loop>
		<source src="{{asset('storage/homepage/vid2.mp4')}}" type="video/mp4" /><p>Your browser doesn't support HTML5 video. Here is
			a <a href="myVideo.mp4">link to the video</a> instead.</p>
	</video>

	<div id="wrapper">

		@include('homepage._side')

		<div id="content">
			<div id="about" class="translateInit-3 translate">
				<h1>O nás</h1>
				<p class="mt-3 fs-30">Programovanie webových stránok, <br>e-commerce a custom riešení na mieru, automatizované testovanie, správa serverov.</p>
				<p class="mt-3 fs-30">PHP, Mysql, Javascript, CSS, HTML, Elasticsearch, Bash, Selenide, ...</p>
			</div>
		</div>

	</div>

@endsection