@extends('layouts.app')

@section('content')
<div class="column">

     @include("partials.errors")

     <form method="POST" action="{{ route('equipment.update', $equipment->id) }}">
        {{ method_field('PATCH') }}

        @include('equipment.form', ['submitButtonText' => 'Update'])
    </form>

</div>

<div class="column is-4-tablet"></div>
@stop