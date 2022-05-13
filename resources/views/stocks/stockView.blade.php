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
                <td>{{$eachStock->quantity}}</td>
                <td>${{$eachStock->quantity * $eachStock->price}}</td>
                <td>{{$eachStock->owner}}</td>
                <td><a href="{{route('edit', ['id' => $eachStock->id])}}">Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    <tr>
        
        <th>Total Cost: ${{ $total }}</th>
        <th>Average Cost per Share: ${{ $total/$stock->sum('quantity') }}</th>
        <th>Total Stocks: {{ $stock->sum('quantity') }}</th>
    </tr>
</table>

<a href="/stocks">Back to main page</a>
@endsection
