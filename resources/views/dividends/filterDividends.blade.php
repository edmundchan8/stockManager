@extends ('layouts.app')
@section('content')
<div class="chart-container"  style="position: relative; height:40vh; width:80vw">
    <canvas id="myChart" width="400" height="400"></canvas>
</div>
<button onclick="toggleMonYea()">Month/Year</button>
<h4 class="mt-4">Your Average Monthly Dividends within the last 12 months is: <strong>${{$lastTwelveMonths/12}}</strong></h4>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let labels = {!! $months !!};
    let graphData = [];
    let isMonYea = "Month";

    /** Setting LABEL and DATA for YEAR */
    /*convert json string to json? */
    let yearData = {!! $yearsTotal !!};
    let yearTotals = [];

    // convert the new json to an object that has a key value pair
    // then push the value to the yearTotals array for use
    // for (let [key, value] of Object.entries(yearData)) {
    //     yearTotals.push(value);
    // }

    /** Setting LABEL and DATA for MONTH */
    /*convert json string to json? */
    let monthData = {!! $monthsTotal !!};
    let monthTotals = [];

    // convert the new json to an object that has a key value pair
    // then push the value to the yearTotals array for use
    for (let [key, value] of Object.entries(monthData)) {
        monthTotals.push(value);
    }

    let data = {
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
        plugins: {
          title: {
            display: true,
            align: "start",
            font: {size: '20'},
            text: `Dividends per ${isMonYea}`
          }
        }
      }
    };

    let myChart = new Chart(
      document.getElementById('myChart'),
      config
    );

    function toggleMonYea(){
      let $newlabel = [];
      let $newTotal = [];
      let $newData = [];

      if(isMonYea == "Month"){
        $newlabel = {!! $years !!};
        $newTotal = yearTotals;
        $newData = yearData;
        isMonYea = "Year";
      }
      else{
        $newlabel = {!! $months !!};
        $newTotal = monthTotals;
        $newData = monthData;
        isMonYea = "Month";
      }

      var data = myChart.config.data;
      data.options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: true,
            align: "start",
            font: {size: '20'},
            text: isMonYea
          }
        }
      };
      data.labels = $newlabel
      for (let [key, value] of Object.entries($newData)) {
        $newTotal.push(value);
      }
      data.datasets[0].data = $newTotal;
      data.datasets[1].data = $newTotal;
      myChart.options.plugins.title = {
            display: true,
            align: "start",
            font: {size: '20'},
            text: `Dividends per ${isMonYea}`
          };
      myChart.update(config);
    }
  </script>

<h4>Dividend Filter</h4>

<form method="GET"  action="{{url('filterDividends')}}">
    <input type="hidden" name="current_dividend_db" value="dividend">
    <label>Name of Dividend</label>
    <input type="text" name="name" placeholder="name"/>
    <br/>
    <label>TickerSymbol</label>
    <input type="text" name="tickerSymbol" placeholder="tickerSymbol"/>
    <input type="submit" name="filter" value="Search"/>
</form>

<br/>
<a href="/dividends">Back to main page</a>

@endsection