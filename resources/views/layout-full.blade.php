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

			<div class="translateInit-2 translate-2 col-xs-12 col-sm-4 col-md-3 col-lg-3 col-lg-offset-1 sidebar" id="sideMenu">

				@include('components.menu.menu')

				<ul>
					@auth
						@if(Auth::user()->hasRole('admin'))
							{{--<li><a {{route('drom')}}>Drom</a></li>--}}
							{{--<li><a href="{{route('admin.default')}}" rel="nofollow">Administrácia</a></li>--}}
						@endif
						<li class="hr pH0"><a href="{{route('logout')}}" rel="nofollow">Odhlásiť</a></li>
						<li>
							<a href="{{route('user.detail')}}" rel="nofollow" class="small1 c1">Prihlásený: {{Auth::user()->name}}</a>
						</li>
					@endauth
					@guest
						<li class="hr pH0"><a data-toggle="modal" data-target="#loginModal" rel="nofollow" class="pointer">Prihlásiť</a></li>
						<li><a data-toggle="modal" data-target="#registerModal" rel="nofollow" class="pointer">Registrovať</a></li>
					@endguest
				</ul>

				<div class="hr"> </div>

			</div>

			<div id="main" class="translateInit translate-2 col-xs-12 col-sm-8 col-md-9 col-lg-7">

				@yield('content')

			</div>

		</div>
	</div>

	<div id="footerPusher"></div>

</div>

<div id="footer">
	<strong>Created & designed by Tatrytec.eu 2020</strong>
</div>

@endsection