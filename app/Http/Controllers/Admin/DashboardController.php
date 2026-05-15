<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $orders      = Order::latest()->get();
        $totalOrders = $orders->count();
        $todayOrders = $orders->filter(fn($o) => $o->created_at->isToday())->count();
        $totalRev    = $orders->where('status', 'delivered')->sum('total_price');
        $topQty      = $orders->groupBy('quantity')->map->count()->sortDesc()->keys()->first() ?? '—';

        return view('admin.dashboard', compact('orders', 'totalOrders', 'todayOrders', 'totalRev', 'topQty'));
    }
}
