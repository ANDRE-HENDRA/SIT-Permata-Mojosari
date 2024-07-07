<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{csrf_token()}}">
		<!-- CSS | Styles -->
		@include('layouts.style')
		@stack('style')
		<style>
		</style>
	<title>
		@isset($title)
		{{$title . ' | '}}
		@endisset
		{{'SIT Permata Mojosari'}}
	</title>
</head>
<body>
	@yield('content')

	@include('layouts.script')
	@stack('script')
</body>
</html>