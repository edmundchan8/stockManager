@extends ('layouts.app')
@section('content')
<div class="chart-container"  style="position: relative; height:40vh; width:80vw">
    <canvas id="myChart" width="400" height="400"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {{ $years }};

    /*convert json string to json? */
    const yearData = {!! $yearsTotal !!};
    const yearTotals = [];

    // convert the new json to an object that has a key value pair
    // then push the value to the yearTotals array for use
    for (let [key, value] of Object.entries(yearData)) {
        yearTotals.push(value);
    }

    const data = {
      labels: labels,
      datasets: [{
        label: 'Dividends',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: yearTotals
      }]
    };
  
    const config = {
      type: 'bar',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
      }
    };
  </script>
  <script>
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>

<h4>Dividend Filter</h4>

<form method="GET">
    <input type="hidden" name="current_dividend_db" value="dividends">
    <label>Name of Dividend</label>
    <input type="text" name="name" placeholder="name"/>
    <br/>
    <label>Ticker Symbol</label>
    <input type="text" name="tickerSymbol" placeholder="ticker"/>
    <br/>
    <label>Date</label>
    <input type="text" name="date" placeholder="date"/>
    <input type="submit" name="filter" value="Search"/>

</form>
<?php
    // if the GET requeust is called for
    if(isset($_GET['filter'])) {
        include_once '../includes/dbh.inc.php';
        $dividend_db = $_GET['current_dividend_db'];
        //default sql search
        $query = "SELECT * FROM $dividend_db";
        $addAND = false;

        // alter the variables (used for 'sql') ONLY
        // if the input text has been put in
        $name = 'name';
        if ($_GET['name'] != ''){
            $name = $_GET['name'];
            if ($addAND){
                $query .= " AND name='$name'";
            }
            else {
                $query .= " WHERE name='$name'";
                $addAND = true;
            }
        }
        //if the ticketsymbol text has been put in
        $ticker = 'tickerSymbol'; 
        if ($_GET['tickerSymbol'] != ''){
            $ticker = $_GET['tickerSymbol'];
            if ($addAND){
                $query .= "AND tickerSymbol='$ticker'";
            }
            else{
                $query .= " WHERE tickerSymbol='$ticker'";
                $addAND = true;
            }
        }
        //if the date text has been put in
        $date = 'date'; 
        if ($_GET['date'] != ''){
            $date = $_GET['date'];
            if ($addAND){
                $query .= "AND date LIKE '%$date%'";
            }
            else{
                $query .= " WHERE date LIKE '%$date%'";
                $addAND = true;
            }
        }
        $query .=";";
        echo $query;
        $total_dividends = 0;
        $result = mysqli_query($conn, $query);
        if(!empty($result)){
            $result_check = mysqli_num_rows($result);
        
            if ($result) {
                echo "<h2>Filter results</h2>";
                echo "<table>
                    <th>Stock</th>
                    <th>Ticker Symbol</th>
                    <th>Amount</th>
                    <th>Date</th>
                    ";
                    //fetch each row from the $result of the sql search, and set to $row
                    // we then access each row with $row
                    if($result_check > 0){
                        while ($row = mysqli_fetch_assoc($result)){
                            echo "<tr><td>" . $row['name'] . "</td>
                            <td>" . $row['tickerSymbol'] . "</td>
                            <td>" . $row['amount'] . "</td>
                            <td>" . $row['date'] . "</td></tr>";
                            $total_dividends += $row['amount'];
                        }
                        echo "</table>";
                        echo "<br/>
                        <p>Total Dividend Amount: $". $total_dividends . ".<br/>
                        <p>If search is within a year, divdends monthly is: $" . $total_dividends / 12 . ".<br/>";
                    }
                    else{
                        echo "No results found"; 
                    }
                }
            }
        else{
            echo "SQL results came back null";
        }
    } 
?>

<br/>
<a href="../index.php">Back to main page</a>
{{-- <tbody>
    @foreach($dividends as $dividend)
    <tr>
        <th>{{$dividend->year}}</th>
    </tr>
    @endforeach
</tbody> --}}


@endsection