@extends('layouts.app')

@section('content')
<section>
	<div class="container">
		<div class="columns">
			<div class="column">

				@include('partials._equipment')

			</div>
		    
		    <div class="column is-4-tablet"></div>
	    </div>
    </div>
</section>
@stop