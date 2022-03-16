@extends ('layouts.app')
@section('content')
<h4>{{$name}}<h4>
<br>
@foreach($stock as $eachStock)
<h6>Date: {{ $eachStock->date }}</h6>
<h6>Dividends earned: {{ $eachStock->amount }}</h6>
<br>
@endforeach
<a href="/filterDividends">Back to main page</a>
@endsection
