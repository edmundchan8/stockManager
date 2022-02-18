@extends ('layouts.app')
@section('content')
    <h6>User Stocks</h6>
    <h6>Full list of bought/sold stocks</h6>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Stock</th>
                <th scope="col">Ticker Symbol</th>
                <th scope="col">Price</th>
                <th scope="col">Buy/Sell</th>
                <th scope="col">Stock Qty</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Apple</th>
                <td>AAPL</td>
                <td>$170</td>
                <td>Buy</td>
                <td>100</td>
                <td>2020-05-12</td>
            </tr>
        </tbody>
    </table>
@endsection