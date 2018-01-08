@extends('layouts.app')

@section('content')
<section class="hero is-fullheight">
	<div class="container has-text-centered">
		<div class="column is-4 is-offset-4">

			<h3 class="title has-text-grey">Login</h3>

			<p class="subtitle has-text-grey">Please login to proceed.</p>

			<div class="box">
<!-- 					<figure class="avatar">
					<img src="https://placehold.it/128x128">
				</figure> -->
				<form id="login" method="POST" action="{{ route('login') }}">
					{{ csrf_field() }}

					<div class="field">
						<div class="control">
							<input id="email" class="input is-large" type="email" name="email" placeholder="Your Email" autofocus required>
							
							@if ($errors->has('email'))
							<p class="help is-danger">
								{{ $errors->first('email') }}
							</p>
							@endif
						</div>
					</div>

					<div class="field">
						<div class="control">
							<input id="password" class="input is-large" type="password" name="password" placeholder="Your Password" required>
							
							@if ($errors->has('password'))
							<p class="help is-danger">
								{{ $errors->first('password') }}
							</p>
							@endif
						</div>
					</div>

					<div class="field">
  						<input id="remember" type="checkbox" name="remember" class="switch is-outlined is-info" c{{ old('remember') ? 'checked' : '' }}>
  						<label for="remember">Remember me?</label>
					</div>

					<!-- <div class="field">
						<label class="checkbox">
							<input type="checkbox" name="remember" >
							Remember me
						</label>
					</div> -->

					<button style="width:100%;margin-top:5px;" type="submit" class="button  is-info is-large">
						Login
					</button>
				</form>
			</div>
			<p class="has-text-grey">
				<a href="{{ route('password.request') }}">Forgot Password?</a>
			</p>
		</div>
	</div>
</section>
@endsection
