@extends ('layouts.app')
@section('content')
<h4>{{$name}}<h4>
<br>

<h5>Stock Portfolio</h5>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Price Per Share</th>
                <th scope="col">Quantity Bought/Sold</th>
                <th scope="col">Total Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stock as $eachStock)
            <tr>
                <td>{{$eachStock->date}}</td>
                <td>{{$eachStock->price}}</td>
                <td>{{$eachStock->quantity}}</td>
                <td>{{$eachStock->quantity * $eachStock->price}}</td>
            </tr>
            @endforeach
        </tbody>
    <tr>
        <th>Total Cost: ${{ $stock->sum('price') }}</th>
        <th>Total Stocks: {{ $stock->sum('quantity') }}</th>
    </tr>
    <tr>
        <th>Last Stock Added: </th>
    </tr>
</table>

<a href="/stocks">Back to main page</a>
@endsection
