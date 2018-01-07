@extends('layouts.app')

@section('content')
<section class="hero is-fullheight">
    <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
            <h3 class="title has-text-grey">Register</h3>
            
            <div class="box">
                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="field">
						<div class="control">
							<input id="name" class="input is-large" value="{{ old('name') }}" type="text" name="name" placeholder="Your Name" autofocus required>

							@if ($errors->has('name'))
							<p class="help is-danger">
								{{ $errors->first('name') }}
							</p>
							@endif
						</div>
                    </div>
                    
                    <div class="field">
						<div class="control">
							<input id="email" class="input is-large" value="{{ old('email') }}" type="email" name="email" placeholder="Your Email" autofocus required>

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
						<div class="control">
							<input id="password_confirmation" class="input is-large" type="password" name="password_confirmation" placeholder="Confirm Password" required>

							@if ($errors->has('password_confirmation'))
							<p class="help is-danger">
								{{ $errors->first('password_confirmation') }}
							</p>
							@endif
						</div>
					</div>

                    <button style="width:100%;margin-top:5px;" type="submit" class="button  is-info is-large">
						Login
					</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
