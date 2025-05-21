@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="left">lewy kontener</div>
        <div class="right">prawy kontener</div>
    </div>
@endsection
<script type="text/javascript" data-url="{{ url('/cart') }}">
    @yield('javascript')
</script>
@vite('resources/js/delete.js')
@vite(['resources/js/checkout.js'])
