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
                <th scope="col">Stock
                    <a href={{ route('stocks', ['sortBy' => 'name'])}}><img src="{{ asset('/upArrow.png') }}" 
                        alt="up arrow" style="height: 10px;"></a>
                    <a href={{ route('stocks', ['sortByDesc' => 'name'])}}><img src="{{ asset('/downArrow.png') }}"
                        alt="down arrow" style="height: 10px;"></a>
                </th>
                <th scope="col">Stock Qty
                    <a href={{ route('stocks', ['sortBy' => 'quantity'])}}><img src="{{ asset('/upArrow.png') }}" 
                        alt="up arrow" style="height: 10px;"></a>
                    <a href={{ route('stocks', ['sortByDesc' => 'quantity'])}}><img src="{{ asset('/downArrow.png') }}"
                        alt="down arrow" style="height: 10px;"></a>
                </th>
                <th scope="col">Investment Total
                    <a href={{ route('stocks', ['sortBy' => 'investmentTotal'])}}><img src="{{ asset('/upArrow.png') }}" 
                        alt="up arrow" style="height: 10px;"></a>
                    <a href={{ route('stocks', ['sortByDesc' => 'investmentTotal'])}}><img src="{{ asset('/downArrow.png') }}"
                        alt="down arrow" style="height: 10px;"></a>
                </th>
                <th scope="col">
                    Market Price
                    <a href={{ route('stocks', ['sortBy' => 'regMarPrice'])}}><img src="{{ asset('/upArrow.png') }}" 
                        alt="up arrow" style="height: 10px;"></a>
                    <a href={{ route('stocks', ['sortByDesc' => 'regMarPrice'])}}><img src="{{ asset('/downArrow.png') }}"
                        alt="down arrow" style="height: 10px;"></a>
                </th>
                <th scope="col">Analyst Rating
                    <a href={{ route('stocks', ['sortBy' => 'avgAnlRat'])}}><img src="{{ asset('/upArrow.png') }}" 
                        alt="up arrow" style="height: 10px;"></a>
                    <a href={{ route('stocks', ['sortByDesc' => 'avgAnlRat'])}}><img src="{{ asset('/downArrow.png') }}"
                        alt="down arrow" style="height: 10px;"></a>
                </th>
                <th scope="col">Analyst Opinion
                    <a href={{ route('stocks', ['sortBy' => 'avgAnlOpn'])}}><img src="{{ asset('/upArrow.png') }}" 
                        alt="up arrow" style="height: 10px;"></a>
                    <a href={{ route('stocks', ['sortByDesc' => 'avgAnlOpn'])}}><img src="{{ asset('/downArrow.png') }}"
                        alt="down arrow" style="height: 10px;"></a>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
                @if ($stock->quantity != 0)
                    <tr>
                        @if(str_contains(url()->current(), 'owner'))
                            <td><a href="/stocks/ownerStock/{{$stock->name}}/{{$stock->owner}}" class="text-decoration-none">{{$stock->name}}</a></td>
                        @else
                            <td><a href="/stocks/{{$stock->name}}" class="text-decoration-none">{{$stock->name}}</a></td>
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