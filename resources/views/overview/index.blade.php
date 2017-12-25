@extends('layouts.app')

@section('content')

    <div class="column is-6-tablet">

        @include('overview._equipment')

    </div>

    <div class="column is-6-tablet">

        @include('overview._work-orders')

    </div>

@stop