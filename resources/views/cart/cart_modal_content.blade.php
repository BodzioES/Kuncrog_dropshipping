@if ($cartItems->isEmpty())
    <p class="text-center">Twój koszyk jest pusty.</p>
@else
    {{-- Desktop: tabela --}}
    <div class="table-responsive cart-table d-none d-md-block">
        <table class="table align-middle">
            <tbody>
            @php $total = 0; @endphp
            @foreach ($cartItems as $item)
                @php
                    $name = $item->product->name ?? $item['name'];
                    $price = $item->product->price ?? $item['price'];
                    $quantity = $item->quantity ?? $item['quantity'];
                    $subtotal = $price * $quantity;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td width="15%">
                        <img src="{{ $item->product->image_url }}" alt="photo"
                             style="width: 80px; height: auto;">
                    </td>
                    <td>{{ $name }}</td>
                    <td class="text-center">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary btn-sm update-cart"
                                    data-id="{{ $item->id ?? $item['id'] }}" data-action="decrease">-</button>
                            <input type="text" class="form-control text-center"
                                   value="{{ $quantity }}" disabled style="max-width: 50px;">
                            <button class="btn btn-outline-secondary btn-sm update-cart"
                                    data-id="{{ $item->id ?? $item['id'] }}" data-action="increase">+</button>
                        </div>
                    </td>
                    <td>
                        <div class="small text-muted">Cena</div>
                        {{ number_format($price, 2) }} PLN
                    </td>
                    <td>
                        <div class="small text-muted">Suma</div>
                        {{ number_format($subtotal, 2) }} PLN
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger delete-cart-item"
                                data-id="{{ $item->id ?? $item['id'] }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mobile: karty --}}
    <div class="cart-mobile d-block d-md-none">
        @foreach ($cartItems as $item)
            @php
                $name = $item->product->name ?? $item['name'];
                $price = $item->product->price ?? $item['price'];
                $quantity = $item->quantity ?? $item['quantity'];
                $subtotal = $price * $quantity;
            @endphp
            <div class="card mb-2">
                <div class="card-body d-flex align-items-center">
                    <img src="{{ $item->product->image_url }}" alt="photo"
                         style="width: 60px; height: auto; margin-right:10px;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $name }}</h6>
                        <div class="input-group input-group-sm mb-1" style="max-width:120px;">
                            <button class="btn btn-outline-secondary btn-sm update-cart"
                                    data-id="{{ $item->id ?? $item['id'] }}" data-action="decrease">-</button>
                            <input type="text" class="form-control text-center"
                                   value="{{ $quantity }}" disabled>
                            <button class="btn btn-outline-secondary btn-sm update-cart"
                                    data-id="{{ $item->id ?? $item['id'] }}" data-action="increase">+</button>
                        </div>
                        <div class="small">Price: {{ number_format($price, 2) }} PLN</div>
                        <div class="small">Total: {{ number_format($subtotal, 2) }} PLN</div>
                    </div>
                    <button class="btn btn-sm btn-danger delete-cart-item ms-2"
                            data-id="{{ $item->id ?? $item['id'] }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center px-3">
        <h5 class="mb-0">Total amount:</h5>
        <h4 class="mb-0">{{ number_format($total, 2) }} PLN</h4>
    </div>
@endif

