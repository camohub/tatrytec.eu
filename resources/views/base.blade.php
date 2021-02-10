@php
    use Illuminate\Support\Facades\Request;
@endphp
<!DOCTYPE html>
<html itemscope itemtype="https://schema.org/Article">
<head>
	<!-- Google Tag Manager -->
	{{--<script>(function(w,d,s,l,i){ w[l]=w[l]||[];w[l].push({ 'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-K3ZF82J');
	</script>--}}
	<!-- End Google Tag Manager -->

	<meta charset="utf-8">
	<meta name="csrf-token" content="{{csrf_token()}}">
	<meta name="description" content="@yield('metaDescription', 'Počítače, webové technológie, servery, databázy, ...')">
	@if(isset($metaRobots))<meta name="robots" content="@yield('metaRobots', 'index,follow')">@endif
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="{{mix('css/app.css')}}">
	<link rel='shortcut icon' type='image/x-icon' href="@assets('/favicon.ico')"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	@if(isset($fb))
		<meta property="og:url" content="{{Request::fullUrl()}}"/>
		<meta property="og:type" content="product"/>
		<meta property="og:title" content="@yield('title', 'Tatrytec.eu')"/>
		<meta property="og:description" content="@yield('metaDescription', 'Počítače, webové technológie, servery, databázy, ...')"/>
		<meta property="og:image" content="@yield('ogImage')"/>
	@endif

	<title>{{env('APP_NAME')}} | @yield('title', 'Tatrytec.eu')</title>
</head>
<body>

{{-- Google Tag Manager (noscript) --}}
<noscript>
	<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K3ZF82J" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
{{-- End Google Tag Manager (noscript) --}}


@yield('body')


<div id="footer">
	<strong>Created & designed by Tatrytec.eu 2020</strong> &nbsp;&nbsp
	<a href="{{route('page', ['page' => 'gdpr-ochrana-osobnych-udajov'])}}">GDPR</a>
</div>


{{-- MODALS --}}
<script>
	let showModal = '{{$showModal}}';
</script>

@include('components.login-form-modal')
@include('components.register-form-modal')


{{-- ALERTS --}}
<div id="alerts-wrapper">
	@include('flash::message')
</div>


{{-- LOADER --}}
<div id="ajax-loader"> </div>

</body>
</html>