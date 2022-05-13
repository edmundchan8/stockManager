@extends ('layouts.app')
@section('content')
<h4>Edit {{$stock->name}} -  ID: {{$stock->id}}</h4> 
<br>
<form method="PUT" action="{{url('stocks')}}">
    @csrf
    <div class="form-group m-3">
        <input class="form-control" type="hidden" name="current_stock_db" value="stocks">
        <label>Stock Name</label>
        <input class="w-25" type="text" name="stockName" value="{{ $stock->name }}">
        <br/>
        <label>Ticker Symbol</label>
        <input class="w-25" type="text" name="tickerSymbol" value="{{ $stock->tickerSymbol }}">
        <br/>
        <select name="buyOrSell">
            <option value="buy">Buy</option>
            <option value="sell">Sell</option>
        </select>
        <br/>
        <label class=mt-3 mb-3">Buy/Sell Price</label>
        <input class="w-25" type="text" name="stockPrice" value="{{ $stock->price }}">
        <br/>
        <label>Amount</label>
        <input class="w-25" type="text" name="stockQty" value="{{ $stock->quantity }}">
        <br/>
        <label>Date</label>
        <input class="w-25 mb-2" type="text" name="date" value="{{ $stock->date }}" placeholder="YYYY/MM/DD">
        <br/>
        <select name="owner">
            <option value="edmund">Edmund</option>
            <option value="priscilla">Priscilla</option>
            <option value="yauyau">Yau Yau</option>
        </select>
        <br/>
        <input type="submit" value="Update Stock">
    </div>
</form>

<a href="/stocks">Back to main page</a>
@endsection
