<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with('address','items.product','paymentMethod','shippingMethod')
            ->get();
        return view('admin.orders.index',compact('orders'));
    }

    public function show(Order $order){
        return view('admin.orders.show',compact('order'));
    }

    public function edit(Order $order){
        return view('admin.orders.edit',compact('order'));
    }

    public function invoice(Order $order){
        $order->load('address','items.product','paymentMethod','shippingMethod');

        $pdf = PDF::loadView('admin.orders.invoice',compact('order'));

        $filename = 'invoice-' . $order->id . '.pdf';

        return $pdf->download($filename);
    }
}
