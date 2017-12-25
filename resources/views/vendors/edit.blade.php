@extends('layouts.app')

@section('content')
<div class="column">

     @include("partials.errors")

     <form method="POST" action="{{ route('vendor.update', $vendor->id) }}">
        {{ method_field('PATCH') }}

        @include('vendors.form', ['submitButtonText' => 'Update'])
    </form>

</div>

<div class="column is-4-tablet"></div>
@stop