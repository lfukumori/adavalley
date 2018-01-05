<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'CMMS') }}</title>

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<!-- Fonts -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
	<div id="app">
		<nav class="navbar has-shadow" role="navigation" aria-label="main navigation">
			<div class="container">
				<div class="navbar-brand">
					<a class="navbar-item" href="{{ url('/') }}">
						{{ config('app.name', 'CMMS') }}
					</a>

					<button class="button navbar-burger" onclick="toggleDropdown('navbarDropdown')">
						<span></span>
						<span></span>
						<span></span>
					</button>
				</div>

				<div id="navbarDropdown" class="navbar-menu">
					<div class="navbar-start">
						<a href="{{ route('equipment.index') }}" class="navbar-item">
							Equipment
						</a>
					</div>

					<div class="navbar-end">
						@guest
						<a class="navbar-item" href="{{ route('login') }}">Login</a>
						<a class="navbar-item" href="{{ route('register') }}">Register</a>
						@else
						<div id="userDropdown" class="navbar-item has-dropdown">
							<a class="navbar-link" role="button" onclick="toggleDropdown('userDropdown')">
								{{ Auth::user()->name }}
							</a>

							<div class="navbar-dropdown">
								<a class="navbar-item" href="{{ route('logout') }}"
								onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								Logout
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</div>
						@endguest
					</div>
				</div>
			</div>
		</nav>

		@yield('content')
	</div>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>
	<script>
		function toggleDropdown(id) {
			let element = document.getElementById(id).classList;

			element.contains('is-active') ? element.remove('is-active') : element.add('is-active');
		}
	</script>
</body>
</html>
