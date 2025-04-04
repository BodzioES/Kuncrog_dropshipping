@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Twój koszyk</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Zdjęcie</th>
                <th>Produkt</th>
                <th>Cena</th>
                <th>Ilość</th>
                <th>Akcje</th>
            </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                     <tr>
                         <td><img src="{{$item->image}}" alt="photo" width="50"></td>
                         <td>{{$item->name}}</td>
                         <td>{{$item->price}} zł</td>
                         <td>{{$item->quantity}}</td>
                         <td>
                             <button class="btn btn-danger delete" data-id="{{$item->id}}">USUN</button>
                         </td>
                     </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
<script type="text/javascript" data-url="{{ url('/cart') }}">
    @yield('javascript')
</script>
@vite('resources/js/delete.js')
