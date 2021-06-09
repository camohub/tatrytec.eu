@extends('layout-homepage')

@section('content')

	<video autoplay muted loop>
		<source src="{{asset('storage/homepage/vid3.mp4')}}" type="video/mp4" /><p>Your browser doesn't support HTML5 video. Here is
			a <a href="myVideo.mp4">link to the video</a> instead.</p>
	</video>

	<div id="wrapper">

		@include('homepage._side')

		<div id="content">
			<div id="contact" class="translateInit-2 translate">
				<h1>Kontakt</h1>
				<div>mail:&nbsp;postmaster@tatrytec.eu</div>
				<div>tel: 0908 534 237</div>
			</div>
		</div>

	</div>

@endsection