{{-- Adding a dividend code --}}
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
        <!-- Add Dividend -->
        <form method="POST" action="{{url('dividends')}}">
            @csrf
            <div class="form-group m-3">
                <input class="form-control" type="hidden" name="current_stock_db" value="dividends">
                <label>Add Stock Name</label>
                <input class="form-control" type="text" name="stockName" value="{{ old('stockName') }}">
                <label>Ticker Symbol</label>
                <input class="form-control" type="text" name="tickerSymbol" value="{{ old('tickerSymbol') }}">
                <label>Amount</label>
                <input class="form-control" type="text" name="amount" value="{{ old('amount') }}">
                <label>Add Date?</label>
                <input class="form-control" type="text" name="date" value="{{ old('date') }}" placeholder="YYYY/MM/DD">
                <input type="submit" value="Add">
            </div>
        </form>
    </div>
</div>