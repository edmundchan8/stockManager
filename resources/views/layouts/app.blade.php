{{-- Default layout for web pages --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Stock Manager</title>
  <meta name="stockManager" content="Site to manage my stocks">
  <meta name="edmundChan" content="edmundChan">
  <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item active" style="margin-right: 2rem;">
            <a class="nav-link h5
            " href="/">Home</a>
          </li>
          <li class="nav-item" style="margin-right: 2rem;">
            <a class="nav-link h5
            " href="stocks">Stocks</a>
          </li>
          <li class="nav-item" style="margin-right: 2rem;">
            <a class="nav-link h5
            " href="dividends">Dividends</a>
          </li>
          <li class="nav-item" style="margin-right: 2rem;">
            <a class="nav-link h5
            " href="#">Log out</a>
          </li>
        </ul>
    </nav> 
    @yield('content')
</body>
</html>