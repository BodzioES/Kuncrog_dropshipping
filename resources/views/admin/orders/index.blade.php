@extends('layouts.admin')

@section('content')
    <div class="container table-container">
        <h3 class="mb-4">Order Tracking</h3>
        <div class="table-responsive shadow-sm rounded bg-white">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th scope="col">Data zamówienia</th>
                    <th scope="col">Numer zamówienia</th>
                    <th scope="col">Osoba kupująca</th>
                    <th scope="col">Metoda płatności</th>
                    <th scope="col">Łączna kwota do zapłaty</th>
                    <th scope="col">Status</th>
                    <th scope="col">Akcje</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->created_at}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->id}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->address->first_name}} {{$order->address->last_name}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->paymentMethod->name}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->total_price}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->status}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">

                            <a href="{{route('admin.orders.show',$order->id)}}">
                                <button><i class="fa-solid fa-magnifying-glass"></i></button>
                            </a>

                            <a href="{{route('admin.orders.edit',$order->id)}}">
                                <button><i class="fa-solid fa-pen-to-square"></i></button>
                            </a>

                            <button class="delete" data-id="{{$order->id}}" data-url="{{route('admin.orders.index')}}"><i class="fa-solid fa-trash"></i></button>

                            <a href="{{route('admin.orders.invoice',$order)}}">
                                <button><i class="fa-solid fa-file-pdf"></i></button>
                            </a>

                        </td>
                    </tr>
                @empty
                    <td colspan="7" class="text-center text-muted py-4">
                        Brak zamówień do wyświetlenia
                    </td>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/delete.js')
    @vite('resources/css/order.css')
@endsection


