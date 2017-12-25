@extends('layouts.app')

@section('styles')
@stop

@section('content')
    <section class="column">
        @foreach($part['attributes'] as $prop => $value)
            <p>
                <span class="title is-5">{{ ucwords($prop) }}: </span>
                <span class="subtitle is-6 has-text-info">{{ $value }}</span>
            </p>
        @endforeach
    </section>


    <section class="column is-4-tablet">
        <div class="box">
            <a href="{{ route('part.edit', $part->id) }}" class="button is-warning">Edit</a>
        </div>

        <div class="box">
            <p class="title is-4">Part Currently On:</p>

            @if ($part->equipment)
                <p class="subtitle is-5">
                    <a href="{{ route('equipment.show', $part->equipment->id) }}">{{ $part->equipment->name }}</a>
                </p>
            @else
                <p>No Equipment Associated With This Part.</p>
            @endif
        </div>
    </section>
@stop