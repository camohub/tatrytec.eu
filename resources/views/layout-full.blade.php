@extends('base')

@section('body')

@section('scripts')
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="{$basePath}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!--script src="{$basePath}/js/netteForms.js"></script-->
<script src="{$basePath}/bower_components/nette-live-form-validation/live-form-validation.js"></script>
<script src="{$basePath}/bower_components/nette.ajax.js/nette.ajax.js"></script>--}}
@endsection

<div id="wrapper">

	<div id="header-wrapper" class="bS2">
		<div class="container">
			<div class="row oH">
				<h1 id="header" class="col-12 oH translate translateInit">Tatr<span id="header-effect">ytec</span>.eu</h1>
			</div>
		</div>
	</div>

	<div class="container zI10">
		<div class="row pT50">

			@include('components.sidebar.sidebar')

			<div id="main" class="translateInit translate-2 col-xs-12 col-sm-8 col-md-9 col-lg-7">

				@yield('content')

			</div>

		</div>
	</div>

	<div id="footerPusher"></div>

</div>

@endsection