<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {

        $range = $request->get('range', 'week');
        $labels = null;
        $totals = [];


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

            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            foreach ($daysOfWeek as $day) {
                $labels[] = __(ucfirst(\Carbon\Carbon::parse($day)->locale('en')->isoFormat('dddd')));
                $totals[] = $earnings[$day] ?? 0;
            }
        }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $range2 = $request->get('range2', 'week2');

        if ($range2 === 'month2') {
            $earningsPrevious = DB::table('orders as o')
                ->selectRaw('DAY(o.created_at) as day, SUM(total_price) as items_total')
                ->whereBetween('o.created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('items_total', 'day');

            $labelsPrevious = range(1, max(now()->daysInMonth, now()->subMonth()->daysInMonth));
            $previousTotals = [];
            foreach ($labelsPrevious as $day) {
                $previousTotals[] = $earningsPrevious[$day] ?? 0;
            }

            $percentageDifferent = [];

            $totals = array_pad($totals, count($labelsPrevious), 0);
            $previousTotals = array_pad($previousTotals, count($labelsPrevious), 0);

            foreach ($labels as $index => $day) {
                $current = $totals[$index] ?? 0;
                $previous = $previousTotals[$index] ?? 0;

                if ($current == 0 && $previous == 0) {
                    $percentageDifferent[$index] = 0; //brak zmiany
                } elseif ($previous == 0) {
                    $percentageDifferent[$index] = 100;
                } else {
                    $percentageDifferent[$index] = round((($current - $previous) / $previous * 100), 2);
                }
            }


        } else {
            $earningsPrevious = DB::table('orders as o')
                ->selectRaw('DAYNAME(o.created_at) as day, SUM(total_price) as items_total')
                ->whereBetween('o.created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
                ->groupBy('day')
                ->pluck('items_total', 'day');

            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $previousTotals = [];
            foreach ($daysOfWeek as $day) {
                $labelsPrevious = __(ucfirst(\Carbon\Carbon::parse($day)->locale('en')->isoFormat('dddd')));
                $previousTotals[] = $earningsPrevious[$day] ?? 0;
            }

            $percentageDifferent = [];

            $maxDays = max(count($totals), count($previousTotals));
            $totals = array_pad($totals, $maxDays, 0);
            $previousTotals = array_pad($previousTotals, $maxDays, 0);;

            foreach ($labels as $index => $day) {
                $current = $totals[$index] ?? 0;
                $previous = $previousTotals[$index] ?? 0;

                if ($current == 0 && $previous == 0) {
                    $percentageDifferent[$index] = 0; //brak zmiany
                } elseif ($previous == 0) {
                    $percentageDifferent[$index] = 100;
                } else {
                    $percentageDifferent[$index] = round((($current - $previous) / $previous * 100), 2);
                }
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
            ->select('p.name', 'pi.image_url', DB::raw('SUM(oi.quantity) as sumProduct'))
            ->groupBy('oi.id_product', 'p.name', 'pi.image_url')
            ->orderByDesc('sumProduct')
            ->first(); //mozemy tez uzyc take(5) aby wybrac 5 najczesciej kupowanych


        return view('admin.dashboard',
            compact(
                'labels',
                'labelsPrevious',
                'previousTotals',
                'totals',
                'range',
                'range2',
                'totalUsers',
                'totalOrders',
                'totalProducts',
                'totalEarnings',
                'totalSumCurrentDay',
                'bestProduct',
                'percentageDifferent',
            ));
    }
}
