@extends ('layouts.app')
@section('content')
<h4>{{$name}}<h4>
<br>

<h5>Stock Portfolio</h5>
<p><strong>Current Price: ${{$data->regularMarketPrice}}</strong> | <strong>Previous Closing Price: ${{$data->regularMarketPreviousClose}}</strong> | <strong>Analyst Rating: {{$data->averageAnalystRating}}</strong></p>
<p><strong>50 Day Average: ${{$data->fiftyDayAverage}}</strong> | <strong>200 Day Average: ${{$data->twoHundredDayAverage}}</strong> | <strong>Forward PE: {{$data->forwardPE}}</strong></p>
<p><strong>Trailing Annual Dividend Rate: ${{$data->trailingAnnualDividendRate}}</strong></p>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Price Per Share</th>
                <th scope="col">Quantity Bought/Sold</th>
                <th scope="col">Total Cost</th>
                <th scope="col">Owner</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stock as $eachStock)
            <tr>
                <td>{{$eachStock->date}}</td>
                <td>${{$eachStock->price}}</td>
                <td>{{round($eachStock->quantity, 3)}}</td>
                <td>${{round($eachStock->quantity * $eachStock->price, 2)}}</td>
                <td>{{$eachStock->owner}}</td>
                <td><a href="{{route('edit', ['id' => $eachStock->id])}}">Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    <tr>
        
        <th>Total Cost: ${{ round($total, 2) }}</th>
        <th>Average Cost per Share: ${{ round($total/$stock->sum('quantity'), 2) }}</th>
        <th>Total Stocks: {{ round($stock->sum('quantity'), 3) }}</th>
    </tr>
</table>

<a href="/stocks">Back to main page</a>
@endsection
