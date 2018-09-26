@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container">
        <form onsubmit="filterTemps(e)" name="temperature" action="/temperature" style="width:50%;margin:0 auto 30px;text-align:center;">
            <input id="date-picker" style="font-size:20px;" type="date" name="date" value="{{$date ?? ''}}">
            <button style="font-size:22px;" type="submit">Show Temps</button>
        </form>

        <div style="display:flex;justify-content:space-around;">
            <div style="border:1px solid black;">
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
                                <td style="text-align:right;">{{ $temperature->created_at->format('F d - g:i a') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No Temperatures Logged!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
       

            <div style="border:1px solid black;">
                <table class="table">
                    <caption>Freezer 1 (old)</caption>
                    <thead>
                        <tr>
                            <th>Degrees</th>
                            <th>DateTime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($freezer1 as $temperature)
                            <tr>
                                <td>{{ $temperature->degrees }} {{ $temperature->scale }}</td>
                                <td style="text-align:right;">{{ $temperature->created_at->format('F d - g:i a') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No Temperatures Logged!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="border:1px solid black;">
                <table class="table">
                    <caption>Freezer 2 (new)</caption>
                    <thead>
                        <tr>
                            <th>Degrees</th>
                            <th>DateTime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($freezer2 as $temperature)
                            <tr>
                                <td>{{ $temperature->degrees }} {{ $temperature->scale }}</td>
                                <td style="text-align:right;">{{ $temperature->created_at->format('F d - g:i a') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No Temperatures Logged!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="border:1px solid black;">
                <table class="table">
                    <caption>Room 6</caption>
                    <thead>
                        <tr>
                            <th>Degrees</th>
                            <th>DateTime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($room6 as $temperature)
                            <tr>
                                <td>{{ $temperature->degrees }} {{ $temperature->scale }}</td>
                                <td style="text-align:right;">{{ $temperature->created_at->format('F d - g:i a') }}</td>
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

@section('scripts')
<script>
    const datePicker = document.getElementById('date-picker');
    const submitBtn = document.getElementById('submit');
    const form = document.forms["temperature"];

    let filterTemps = function(e) {
        e.preventDefault();

        form.action = "/temperature?date=" + datePicker.value;
        console.log('test');
        e.submit();
    }
</script>
@endsection
