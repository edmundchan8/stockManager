@extends ('layouts.app')
@section('content')
<div class="chart-container"  style="position: relative; height:40vh; width:80vw">
    <canvas id="myChart" width="400" height="400"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! $months !!};

    /** Setting LABEL and DATA for YEAR */
    /*convert json string to json? */
    const yearData = {!! $yearsTotal !!};
    const yearTotals = [];

    // convert the new json to an object that has a key value pair
    // then push the value to the yearTotals array for use
    for (let [key, value] of Object.entries(yearData)) {
        yearTotals.push(value);
    }

    /** Setting LABEL and DATA for MONTH */
    /*convert json string to json? */
    const monthData = {!! $monthsTotal !!};
    const monthTotals = [];

    // convert the new json to an object that has a key value pair
    // then push the value to the yearTotals array for use
    for (let [key, value] of Object.entries(monthData)) {
        monthTotals.push(value);
    }


    const data = {
      labels: labels,
      datasets: [{
        label: 'Dividends',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: monthTotals,
      }, 
      {
        label: 'Dividends',
        type: 'line',
        data: monthTotals,
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
    <label>Date</label>
    <input type="text" name="date" placeholder="date"/>
    <input type="submit" name="filter" value="Search"/>

</form>

<br/>
<a href="../index.php">Back to main page</a>

@endsection