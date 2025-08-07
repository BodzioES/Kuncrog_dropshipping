<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
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
        $shippingMethods = ShippingMethod::all();
        $paymentMethods = PaymentMethod::all();
        $statuses = ['pending','shipped','delivered','cancelled'];
        return view('admin.orders.edit',compact('order','statuses','shippingMethods','paymentMethods'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'order.id' => 'required|integer',
            'order.status' => 'required|in:pending,shipped,delivered,cancelled',
            'order.id_payment_method' => 'required|integer',
            'order.id_shipping_method' => 'required|integer',
            'order.total_price' => 'required|numeric',
            'order.created_at' => 'required|date',

            'address.first_name' => 'required|string',
            'address.last_name' => 'required|string',
            'address.street_and_house_number' => 'required|string',
            'address.apartment_number' => 'nullable|string|max:255',
            'address.postal_code' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
        ]);

        // 1. Nadpis danych zamówienia
        $order->fill($validated['order']);
        $order->save();

        // 2. Nadpis danych adresowe
        if (isset($validated['address'])){
            $order->address->update($validated['address']);
        }

        return redirect()->route('admin.orders.index')->with('success','Order status has been updated');
    }

    public function invoice(Order $order){
        $order->load('address','items.product','paymentMethod','shippingMethod');

        $pdf = PDF::loadView('admin.orders.invoice',compact('order'));

        $filename = 'invoice-' . $order->id . '.pdf';

        return $pdf->download($filename);
    }
}
