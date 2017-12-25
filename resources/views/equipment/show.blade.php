@extends('layouts.app')

@section('styles')
@stop

@section('content')
	<section class="column">
		@foreach($equipment['attributes'] as $prop => $value)
			<p>
				<span class="title is-5">{{ ucwords($prop) }}: </span>
				<span class="subtitle is-6 has-text-info">{{ $value }}</span>
			</p>
		@endforeach
	</section>

	<section class="column is-4-tablet">
		<div class="box">
			<a href="{{ route('equipment.edit', $equipment->id) }}" class="button is-warning">Edit</a>
		</div>

		<div class="box">
			<h1 class="title is-3">Parts On Equipment</h1>
			<ul>
				@forelse($equipment->parts as $part)
					<li><a href="{{ route('part.show', $part->id) }}">{{ $part->name }}</a></li>
				@empty
					No Parts Associated With This Piece Of Equipment.
				@endforelse
			</ul>
		</div>
	</section>
@stop