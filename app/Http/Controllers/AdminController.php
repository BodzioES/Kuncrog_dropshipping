<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class AdminController extends Controller
{
    public function index(Request $request){

        $range = $request->get('range', 'week');

        if ($range === 'month') {
            $earnings = DB::table('orders as o')
                ->join(DB::raw('(SELECT id_order, SUM(quantity * current_price) as items_total
                             FROM order_items
                             GROUP BY id_order) as io'), 'o.id', '=', 'io.id_order')
                ->leftJoin('shipping_methods as sm', 'sm.id', '=', 'o.id_shipping_method')
                ->selectRaw('DAY(o.created_at) as day, SUM(io.items_total + COALESCE(sm.price,0)) as total')
                ->whereBetween('o.created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('total', 'day');

            $labels = range(1, now()->daysInMonth);
            $totals = [];
            foreach ($labels as $day) {
                $totals[] = $earnings[$day] ?? 0;
            }
        } else {
            $earnings = DB::table('orders as o')
                ->join(DB::raw('(SELECT id_order, SUM(quantity * current_price) as items_total
                             FROM order_items
                             GROUP BY id_order) as io'), 'o.id', '=', 'io.id_order')
                ->leftJoin('shipping_methods as sm', 'sm.id', '=', 'o.id_shipping_method')
                ->selectRaw('DAYNAME(o.created_at) as day, SUM(io.items_total + COALESCE(sm.price,0)) as total')
                ->whereBetween('o.created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->groupBy('day')
                ->pluck('total', 'day');

            $daysOfWeek = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            $labels = [];
            $totals = [];
            foreach ($daysOfWeek as $day) {
                $labels[] = __(ucfirst(\Carbon\Carbon::parse($day)->locale('en')->isoFormat('dddd')));
                $totals[] = $earnings[$day] ?? 0;
            }
        }

        $totalUsers = count(User::all());
        $totalOrders = count(Order::all());
        $totalProducts = count(Product::all());
        $totalEarnings = DB::table('orders')->sum('total_price');
        $totalSumCurrentDay = DB::table('orders')->whereDay('created_at', now()->day)->sum('total_price');

        $bestProduct = DB::table('order_items as oi')
            ->join('products as p', 'p.id', '=', 'oi.id_product')
            ->join('product_images as pi', function ($join) {
                $join->on('pi.id_product', '=', 'p.id')
                    ->where('pi.is_main', '=', 1); //tylko glowne zdjecie
            })
            ->select('p.name','pi.image_url',DB::raw('SUM(oi.quantity) as sumProduct'))
            ->groupBy('oi.id_product','p.name','pi.image_url')
            ->orderByDesc('sumProduct')
            ->first(); //mozemy tez uzyc take(5) aby wybrac 5 najczesciej kupowanych





        return view('admin.dashboard',
            compact(
                'labels',
                'totals',
                'range',
                'totalUsers',
                'totalOrders',
                'totalProducts',
                'totalEarnings',
                'totalSumCurrentDay',
                'bestProduct',
            ));
    }
}
