@extends ('layouts.app')
@section('content')   
<h6>Add Stocks</h6>
    <!-- Add Stock, Price bought/sold, Date and Qty -->
    <form method="POST" action="../includes/addStock.inc.php">
        <input type="hidden" name="current_stock_db" value="yauyau_stocks">
        <label>Add Stock Name</label>
        <br>
        <input type="text" name="stockName" value="">
        <br>
        <br>
        <label>Ticker Symbol</label>
        <br>
        <input type="text" name="tickerSymbol" value="">
        <input type="checkbox" name="newStock">New Stock?
        <br><br>
        <label>Buy/Sell Price</label>
        <br>
        <select name="buyOrSell">
            <option value="buy">Buy</option>
            <option value="sell">Sell</option>
        </select>
        <input type="text" name="stockPrice" value="">
        <br><br>
        <label>Amount</label>
        <br>
        <input type="text" name="stockQty" value="">
        <br>
        <label>Add Date?</label>
        <br>
        <input type="text" name="date" value="" placeholder="YYYY/MM/DD">
        <br>
        <input type="submit" value="Add">
    </form>
    <a href="../index.php">Back to main page</a>
@endsection