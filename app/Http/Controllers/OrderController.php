<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $query = Order::with('address','items.product','paymentMethod','shippingMethod');

        if ($status = $request->query('status')){
            $query->where('status', $status);
        }

        if ($id = $request->query('id')){
            $query->where('id', $id);
        }

        if ($date_from = $request->query('created_at')){
            $query->whereDate('created_at', $date_from);
        }

        if ($fullName = $request->query('full_name')){
            $fullName = trim($fullName);
            $query->whereHas('address',function($q) use ($fullName){
                $q->whereRaw("CONCAT(first_name, ' ', last_name) like '%{$fullName}%'")
                ->orWhereRaw("CONCAT(last_name, ' ', first_name) like '%{$fullName}%'");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index',compact('orders'));
    }

    public function show(Order $order){
        $order->load('address','items.product','paymentMethod','shippingMethod');
        return view('admin.orders.show',compact('order'));
    }

    public function edit(Order $order){
        return view('admin.orders.edit',compact('order'));
    }

    public function update(Request $request, Order $order){
        $order->fill($request->validated()->save());

        return redirect()->route('admin.orders.index')->with('success','Order status has been updated');
    }

    public function invoice(Order $order){
        $order->load('address','items.product','paymentMethod','shippingMethod');

        $pdf = PDF::loadView('admin.orders.invoice',compact('order'));

        $filename = 'invoice-' . $order->id . '.pdf';

        return $pdf->download($filename);
    }
}
