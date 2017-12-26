@extends("layouts.app")

@section("content")
    <div class="column">

    	<h2 class="title has-text-centered">Create Equipment</h2>

        @include("partials.errors")
        
    	<form method="POST" action="{{ url('/equipment') }}">

    	    @include("equipment.form", ["submitButtonText" => "Create"])

    	</form>

    </div>

    <div class="column is-4-tablet"></div>
@stop