@extends ('layouts.app')
@section('content') 

<h4>User(NAME?) Stocks</h4>

{{-- Add stocks component --}}
@include('stocks.addStocks')

{{-- Displaying current stocks from database  --}}

    <h5>Stock Portfolio</h5>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Stock</th>
                <th scope="col">Stock Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <th>{{$stock->name}}</th>
                <td>{{$stock->quantity}}</td>
            </tr>
            @endforeach
        </tbody>
    <tr>
        <th>Total Investments: ${{ $stocks->sum('total') }}</th>
        <th>Total Stocks: {{ $stocks->sum('quantity') }}</th>
    </tr>
    <tr>
        <th>Last Stock Added: {{ $lastStock->name }} on {{ $lastStock->date }}</th>
    </tr>
</table>

    <a href="#">Back to main page</a>
@endsection