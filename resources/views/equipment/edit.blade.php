@extends('layouts.app')

@section('content')
<section>
	<div class="container">
		<div class="columns">

			<div class="column is-6-tablet is-offset-2">

				@include("partials.errors")

				<form method="POST" action="{{ route('equipment.update', $equipment->id) }}">
					{{ method_field('PATCH') }}

					@include('equipment.form', ['submitButtonText' => 'Update'])
				</form>

			</div>

			<div class="column is-4-tablet"></div>
		</div>
	</div>
</section>
@stop