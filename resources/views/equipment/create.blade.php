@extends("layouts.app")

@section("content")
<section>
	<div class="container">
		<div class="columns">

			<div class="column is-6-tablet is-offset-2">

				<h2 class="title has-text-centered">Create Equipment</h2>

				@include("partials.errors")

				<form method="POST" action="{{ url('/equipment') }}">

					@include("equipment.form", ["submitButtonText" => "Create"])

				</form>

			</div>

			<div class="column is-4-tablet"></div>
		</div>
    </div>
</section>

</div>
@stop