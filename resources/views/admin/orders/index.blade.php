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
                <!-- Przykładowy pusty wiersz / można zastąpić danymi -->
                <tr>
                    <td colspan="1" class="text-center text-muted py-4">
                        Brak zamówień do wyświetlenia
                    </td>
                    <td colspan="1" class="text-center text-muted py-4">
                        Brak zamówień do wyświetlenia
                    </td>
                    <td colspan="1" class="text-center text-muted py-4">
                        Brak zamówień do wyświetlenia
                    </td>
                    <td colspan="1" class="text-center text-muted py-4">
                        Brak zamówień do wyświetlenia
                    </td>
                    <td colspan="1" class="text-center text-muted py-4">
                        Brak zamówień do wyświetlenia
                    </td>
                    <td colspan="1" class="text-center text-muted py-4">
                        Brak zamówień do wyświetlenia
                    </td>
                    <td colspan="1" class="text-center text-muted py-4">
                        Brak zamówień do wyświetlenia
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script data-url="{{ route('products.index') }}"></script>
    @vite('resources/js/delete.js')
    @vite('resources/css/order.css')
@endsection


