@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Degrees</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($temperatures as $temperature)
                            <tr>
                                <td>{{ $temperature->degrees }} {{ $temperature->scale }}</td>
                                <td>{{ $temperature->created_at->timezone('America/Detroit')->format('Y-m-d h:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No Temperatures Logged!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
