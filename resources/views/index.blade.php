@extends ('layouts.app')
@extends ('api')
@section('content')
Home Page
    <img src="{{ asset('/homepage.jpg') }}" alt="Image of Stock Manager Home Page" style="height: 300px;"
    class="mx-auto d-block" title="Stock Manager Home Page">
    {{-- Click to call api that gets latest data, on click, notification should pop up to day data is being obtained --}}
    <a href="{{route('data')}}">Click me to get updated Stock Data</a>
@endsection