@extends ('layouts.app')
@section('content')
<h4>Edmund's Dividends</h4>

{{-- Add dividends component --}}
@include('dividends.addDividends')

{{-- Displaying current stocks from database  --}}

    <h5>Dividend Portfolio</h5>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Stock</th>
                <th scope="col">Dividend Given Out</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dividends as $dividend)
            <tr>
                <th><a href="dividends/{{ $dividend->name }}" class="text-decoration-none">{{$dividend->name}}</a></th>
                <td>{{$dividend->amount}}</td>
            </tr>
            @endforeach
        </tbody>
    <tr>
        <th>Total Dividend Given Out: ${{ $dividends->sum('amount') }}</th>
    </tr>
    <tr>
        <th>Last Dividend added: {{ $lastDiv->name }} on {{ $lastDiv->date }}</th>
    </tr>
</table>

    <a href="/">Back to main page</a>
@endsection