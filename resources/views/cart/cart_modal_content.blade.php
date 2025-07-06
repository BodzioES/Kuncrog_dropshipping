@if ($cartItems->isEmpty())
    <p class="text-center">Twój koszyk jest pusty.</p>
@else
    <div class="table-responsive">
        <table class="table align-middle">
            <tbody>
            @php $total = 0; @endphp
            @foreach ($cartItems as $item)
                @php
                    $name = $item->product->name ?? $item['name'];
                    $price = $item->product->price ?? $item['price'];
                    $quantity = $item->quantity;
                    $subtotal = $price * $quantity;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td width="15%">
                        <img src="{{ $item->product->photo_url ?? '' }}" class="img-fluid" alt="{{ $name }}">
                    </td>
                    <td>
                        {{ $name }}
                    </td>
                    <td class="text-center">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary btn-sm update-cart" data-id="{{ $item->product->id ?? $item['id'] }}" data-action="decrease">-</button>
                            <input type="text" class="form-control text-center" value="{{ $quantity }}" disabled style="max-width: 50px;">
                            <button class="btn btn-outline-secondary btn-sm update-cart" data-id="{{ $item->product->id ?? $item['id'] }}" data-action="increase">+</button>
                        </div>
                    </td>
                    <td>{{ number_format($price, 2) }} $</td>
                    <td>{{ number_format($subtotal, 2) }} $</td>
                    <td>
                        <button class="btn btn-sm btn-danger delete-cart-item" data-id="{{ $item->product->id ?? $item['id'] }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center px-3">
        <h5 class="mb-0">Łączna suma:</h5>
        <h4 class="mb-0">{{ number_format($total, 2) }} PLN</h4>
    </div>
@endif

