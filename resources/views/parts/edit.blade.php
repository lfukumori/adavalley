@extends('layouts.app')

@section('content')
<div class="column">
    
    @include("partials.errors")

    <form method="POST" action="{{ route('part.update', $part->id) }}">
        {{ method_field('PATCH') }}

        @include('parts.form', ['submitButtonText' => 'Update'])
    </form>

</div>

<div class="column is-4-tablet"></div>
@stop