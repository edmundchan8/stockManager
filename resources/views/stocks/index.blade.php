@extends ('layouts.app')
@section('content') 

<h4>Stock Portfolio</h4>

{{-- Add stocks component --}}
@include('stocks.addStocks')

{{-- Displaying current stocks from database  --}}

    <h5>Stock Portfolio</h5>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Stock</th>
                <th scope="col">Stock Qty</th>
                <th scope="col">Current Market Price</th>
                <th scope="col">Analyst Rating</th>
                <th scope="col">Analyst Opinion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
                @if ($stock->quantity != 0)
                    <tr>
                        <th><a href="/stocks/{{$stock->name}}" class="text-decoration-none">{{$stock->name}}</a></th>
                        <td>{{$stock->quantity}}</td>
                        <td>${{$stock->regMarPrice}}</td>
                        <td>{{$stock->avgAnlRat}}</td>
                        <td>{{$stock->avgAnlOpn}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    <tr>
        <th>Total Investments: ${{ $stocks->sum('total') }}</th>
        <th>Total Stocks: {{ $stocks->sum('quantity') }}</th>
    </tr>
    <tr>
        <th>Last Stock Added/Removed: {{ $lastStock->name }} on {{ $lastStock->date }}</th>
    </tr>
</table>

    <a href="#">Back to main page</a>
@endsection