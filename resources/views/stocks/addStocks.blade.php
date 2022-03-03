{{-- Adding a stock code --}}
<div id="accordion">
    @if(Session::has('success'))
            <div class="alert alert-success text-center">
                {{Session::get('success')}}
            </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="panel">
        <!-- Add Stock, Price bought/sold, Date and Qty -->
        <form method="POST" action="{{url('stocks')}}">
            @csrf
            <div class="form-group m-3">
                <input type="checkbox" name="newStock">
                <small>New Stock?</small>
                <br>
                <input class="form-control" type="hidden" name="current_stock_db" value="yauyau_stocks">
                <label>Stock Name</label>
                <input class="w-25" type="text" name="stockName" value="{{ old('stockName') }}">
                <label>Ticker Symbol</label>
                <input class="w-25" type="text" name="tickerSymbol" value="{{ old('tickerSymbol') }}">
                <br/>
                <select name="buyOrSell">
                    <option value="buy">Buy</option>
                    <option value="sell">Sell</option>
                </select>
                <label class=mt-3 mb-3">Buy/Sell Price</label>
                <input class="w-25" type="text" name="stockPrice" value="{{ old('stockPrice') }}">
                <label>Amount</label>
                <input class="w-25" type="text" name="stockQty" value="{{ old('stockQty') }}">
                <label>Add Date?</label>
                <input class="w-25 mb-2" type="text" name="date" value="{{ old('date') }}" placeholder="YYYY/MM/DD">
                <input type="submit" value="Add">
            </div>
        </form>
    </div>
</div>