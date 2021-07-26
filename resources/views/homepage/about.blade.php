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
				<p class="mt-3 fs-30">
					<span class="about-hover">Programovanie webových stránok</span>,
					<span class="about-hover">eshopov</span> a <span class="about-hover">custom riešení na mieru</span>,
					<span class="about-hover">správa serverov</span>,
					<span class="about-hover">automatizované testovanie</span>.
				</p>
				<p class="mt-3 fs-30">
					<span class="about-hover">PHP</span>,
					<span class="about-hover">Mysql</span>,
					<span class="about-hover">Postgresql</span>,
					<span class="about-hover">Javascript</span>,
					<span class="about-hover">CSS</span>,
					<span class="about-hover">HTML</span>,
					<span class="about-hover">Elasticsearch</span>,
					<span class="about-hover">Laravel</span>,
					<span class="about-hover">Nette</span>,
					<span class="about-hover">Yii2</span>,
					<span class="about-hover">Git</span>,
					<span class="about-hover">Bash</span>,
					<span class="about-hover">Linux</span>,
					<span class="about-hover">Selenide</span>,
					<span class="about-hover">Vue2</span>,
					...
				</p>
			</div>
		</div>

	</div>

@endsection