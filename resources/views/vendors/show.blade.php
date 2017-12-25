@extends('layouts.app')

@section('styles')
@stop

@section('content')
    <section class="column">
        @foreach($vendor['attributes'] as $prop => $value)
            <p>
                <span class="title is-5">{{ ucwords($prop) }}: </span>
                <span class="subtitle is-6 has-text-info">{{ $value }}</span>
            </p>
        @endforeach
    </section>

    <section class="column is-4-tablet">
        <div class="box">
            <a href="{{ route('vendor.edit', $vendor->id) }}" class="button is-warning">Edit</a>
        </div>

        <div class="box">
            <h1 class="title is-3">Vendors Part List</h1>
            <ul>
                @forelse($vendor->equipment as $equipment)
                    <li><a href="{{ route('equipment.show', $equipment->id) }}">{{ $equipment->name }}</a></li>
                @empty
                    No Equipment Associated With This Vendor.
                @endforelse
            </ul>
        </div>
    </section>
@stop