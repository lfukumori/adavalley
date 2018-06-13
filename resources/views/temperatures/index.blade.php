@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container">
       
        <div style="display:flex;justify-content:space-around">
            <div>
                <table class="table">
                    <caption>Cooler</caption>
                    <thead>
                        <tr>
                            <th>Degrees</th>
                            <th>DateTime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cooler as $temperature)
                            <tr>
                                <td>{{ $temperature->degrees }} {{ $temperature->scale }}</td>
                                <td>{{ $temperature->created_at->format('F d - g:i a') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No Temperatures Logged!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
       

            <div>
                <table class="table">
                    <caption>Freezer</caption>
                    <thead>
                        <tr>
                            <th>Degrees</th>
                            <th>DateTime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($freezer as $temperature)
                            <tr>
                                <td>{{ $temperature->degrees }} {{ $temperature->scale }}</td>
                                <td>{{ $temperature->created_at->format('F d - g:i a') }}</td>
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
