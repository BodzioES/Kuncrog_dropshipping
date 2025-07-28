<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    body {
        background-color: #ffe8d2;
        font-family: 'Montserrat', sans-serif;
    }
</style>
<div class="container mt-5 mb-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-left logo p-2 px-5">
                    <img src="https://dummyimage.com/300x240/fc00fc/000000.jpg&text=image" width="50">
                </div>
                <div class="invoice p-5">
                    <h5>Your order Confirmed!</h5>
                    <span class="font-weight-bold d-block mt-4">Hello, Chris</span>
                    <span>You order has been confirmed and will be shipped in next two days!</span>

                    <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">

                        <table class="table table-borderless">

                            <tbody>
                            <tr>
                                <td>
                                    <div class="py-2">
                                        <span class="d-block text-muted">Order Date</span>
                                        <span>12 Jan,2018</span>
                                    </div>
                                </td>

                                <td>
                                    <div class="py-2">
                                        <span class="d-block text-muted">Order No</span>
                                        <span>MT12332345</span>
                                    </div>
                                </td>

                                <td>
                                    <div class="py-2">
                                        <span class="d-block text-muted">Payment</span>
                                        <span><img src="https://dummyimage.com/300x240/fc00fc/000000.jpg&text=image" width="20" /></span>
                                    </div>
                                </td>

                                <td>
                                    <div class="py-2">
                                        <span class="d-block text-muted">Shiping Address</span>
                                        <span>414 Advert Avenue, NY,USA</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="product border-bottom table-responsive">

                        <table class="table table-borderless">
                            <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td width="20%">
                                    <img src="https://dummyimage.com/300x240/fc00fc/000000.jpg&text=image"
                                         class="product-img me-3"
                                         alt="photo"
                                         style="width: 80px; height: auto; object-fit: contain;">
                                </td>

                                <td width="60%">
                                    <span class="font-weight-bold">{{$item->product->name}}</span>
                                    <div class="product-qty">
                                        <span class="d-block">Quantity: x{{$item->quantity}}</span>
                                    </div>
                                </td>
                                <td width="20%">
                                    <div class="text-right">
                                        <span class="font-weight-bold">{{$item->product->price * $item->quantity}} zł</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-5">
                            <table class="table table-borderless">
                                <tbody class="totals">

                                <tr>
                                    <td>
                                        <div class="text-left">
                                            @php
                                                $totalPrice = 0;
                                             @endphp
                                            @foreach($order->items as $item)
                                                @php
                                                    $totalPrice += $item->product->price * $item->quantity
                                                @endphp
                                            @endforeach
                                            <span class="text-muted">Łączna kwota produktów: </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-right">
                                            <span>{{$totalPrice}} zł</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="text-left">
                                            <span class="text-muted">Metoda Płatności</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-right">
                                            <span>{{$order->paymentMethod->name}}</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="text-left">
                                            <span class="text-muted">Opłata za dostawe</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-right">
                                            <span>{{$order->shippingMethod->name}}</span>
                                            <span>{{number_format($order->shippingMethod->price,2)}} zł</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-top border-bottom">
                                    <td>
                                        <div class="text-left">
                                            <span class="font-weight-bold">Łączna kwota</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-right">
                                            @php
                                                $shippingCost = $totalPrice + $order->id_shipping_method->price
                                            @endphp
                                            <span class="font-weight-bold">{{$shippingCost}} zł</span>
                                        </div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p>We will be sending shipping confirmation email when the item shipped successfully!</p>
                    <p class="font-weight-bold mb-0">Thanks for shopping with us!</p>
                    <span>Nike Team</span>
                </div>
                <div class="d-flex justify-content-between footer p-3">
                    <span>Need Help? visit our <a href="#"> help center</a></span>
                    <span>12 June, 2020</span>
                </div>
            </div>
        </div>
    </div>
</div>
