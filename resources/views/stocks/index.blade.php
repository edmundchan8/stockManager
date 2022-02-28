@extends ('layouts.app')
@section('content')
    <h4>User Stocks</h4>

    <h6>Add a Stock</h6>
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#addStockAccordion" aria-expanded="false" aria-controls="collapseTwo">
        Accordion Item #2
    </button>
    <div id="addStockAccordion" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <!-- Add Stock, Price bought/sold, Date and Qty -->
            <form method="POST" action="../includes/addStock.inc.php">
                <div class="form-group m-3">
                    <input type="checkbox" name="newStock">
                    <small>New Stock?</small>
                    <br>
                    <input class="form-control" type="hidden" name="current_stock_db" value="yauyau_stocks">
                    <label>Stock Name</label>
                    <input class="w-25" type="text" name="stockName" value="">
                    <label>Ticker Symbol</label>
                    <input class="w-25" type="text" name="tickerSymbol" value="">
                    <label class="w-25 mt-3 mb-3">Buy/Sell Price</label>
                    <select name="buyOrSell">
                        <option value="buy">Buy</option>
                        <option value="sell">Sell</option>
                    </select>
                    <input class="w-25" type="text" name="stockPrice" value="">
                    <label>Amount</label>
                    <input class="w-25" type="text" name="stockQty" value="">
                    <label>Add Date?</label>
                    <input class="w-25 mb-2" type="text" name="date" value="" placeholder="YYYY/MM/DD">
                    <input type="submit" value="Add">
                </div>
            </form>
        </div>
    </div>
    <a href="../index.php">Back to main page</a>

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
    </table>

    <h6>Total Investments: ${{ $stocks->sum('total') }} </h6>
    <h6>Total Stocks: {{ $stocks->sum('quantity') }}</h6>
    <a href="#">Back to main page</a>
@endsection