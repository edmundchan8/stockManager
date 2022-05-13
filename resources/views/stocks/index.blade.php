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
                        <td>{{round($stock->quantity, 3)}}</td>
                        <td>${{round($stock->investmentTotal, 2)}}</td>
                        <td>${{$stock->regMarPrice}}</td>
                        <td>{{$stock->avgAnlRat}}</td>
                        <td>{{$stock->avgAnlOpn}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    <tr>
        <th>Total Investments: ${{ round($stocks->sum('investmentTotal'), 2) }}</th>
        <th>Total Stocks: {{ round($stocks->sum('quantity'), 3) }}</th>
    </tr>
    <tr>
        <th>Current Portfolio Value: ${{ round($stocks->sum('currentTotal'), 2) }}</th>
        <th>Investment Difference: ${{ round($stocks->sum('currentTotal') - $stocks->sum('investmentTotal'), 2) }}</th>
        <th>Percent Difference: {{ round(($stocks->sum('currentTotal') - $stocks->sum('investmentTotal')) / $stocks->sum('investmentTotal') * 100, 2)}}%</th>
    </tr>
    <tr>
        <th>Last Stock Added/Removed: {{ $lastStock->name }} on {{ $lastStock->date }}</th>
    </tr>
</table>

    <a href="#">Back to main page</a>
@endsection