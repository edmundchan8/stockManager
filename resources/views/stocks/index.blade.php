@extends ('layouts.app')
@section('content') 

@if(str_contains(url()->current(), 'owner'))
    <h4>{{ ucfirst($stocks[0]->owner) }} Portfolio</h4>
@else
    <h4>Stock Portfolio</h4>
@endif

{{-- Add stocks component --}}
@include('stocks.addStocks')

{{-- Displaying current stocks from database  --}}
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
                        @if(str_contains(url()->current(), 'owner'))
                            <th><a href="/stocks/ownerStock/{{$stock->name}}/{{$stock->owner}}" class="text-decoration-none">{{$stock->name}}</a></th>
                        @else
                            <th><a href="/stocks/{{$stock->name}}" class="text-decoration-none">{{$stock->name}}</a></th>
                        @endif
                        <td>{{$stock->quantity}}</td>
                        <td>${{ $stock->investmentTotal}}</td>
                        <td>${{$stock->regMarPrice}}</td>
                        <td>{{$stock->avgAnlRat}}</td>
                        <td>{{$stock->avgAnlOpn}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    <tr>
        <th>Total Investments: ${{ $stocks->sum('investmentTotal') }}</th>
        <th>Total Stocks: {{ $stocks->sum('quantity') }}</th>
    </tr>
    <tr>
        <th>Current Portfolio Value: ${{ $stocks->sum('currentTotal') }}</th>
        <th>Investment Difference: ${{ $stocks->sum('currentTotal') - $stocks->sum('investmentTotal') }}</th>
        <th>Percent Difference: {{ ($stocks->sum('currentTotal') - $stocks->sum('investmentTotal')) / $stocks->sum('investmentTotal') * 100}}%</th>
    </tr>
    <tr>
        <th>Last Stock Added/Removed: {{ $lastStock->name }} on {{ $lastStock->date }}</th>
    </tr>
</table>

    <a href="#">Back to main page</a>
@endsection