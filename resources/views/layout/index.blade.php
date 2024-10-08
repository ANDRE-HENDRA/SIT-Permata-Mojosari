<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{csrf_token()}}">
	<!-- CSS | Styles -->
	@include('layout.style')
	@stack('style')
	<style>
	</style>
	<title>
		{{'SIT Permata Mojosari'}}
		@isset($title)
		{{' | ' . $title}}
		@endisset
	</title>
</head>
<body class="hold-transition @guest login-page @endguest @auth sidebar-mini layout-fixed @endauth">
{{-- <body class="hold-transition sidebar-mini layout-fixed"> --}}
	
	<div class="wrapper">
		@auth
		@include('layout.navbar')
		@include('layout.sidebar')
		@endauth
		
		@guest
		<div class="d-flex align-items-center h-100">
			@yield('content')
		</div>
		@endguest

		@auth
		<div class="content-wrapper pt-2">
			@include('layout.breadcrumb')
			@yield('content')
		</div>
		@endauth
		
		@auth
		@include('layout.footer')
		@endauth
	</div>
	{{-- script --}}
	@include('layout.script')
	@stack('script')
</body>
</html>