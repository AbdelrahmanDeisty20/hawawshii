<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $orders = $query->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);
        return response()->json(['ok' => true]);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['ok' => true]);
    }

    public function clear()
    {
        Order::truncate();
        return response()->json(['ok' => true]);
    }

    public function export()
    {
        $orders = Order::latest()->get();
        $headers = ['Content-Type' => 'text/csv; charset=UTF-8'];
        $filename = 'orders_' . now()->format('Y-m-d') . '.csv';

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($file, ['#', 'الاسم', 'الهاتف', 'المنطقة', 'العنوان', 'الكمية', 'الإجمالي', 'الحالة', 'الوقت']);
            foreach ($orders as $o) {
                fputcsv($file, [
                    $o->id, $o->name, $o->phone, $o->area, $o->address,
                    $o->quantity, $o->total_price, $o->status,
                    $o->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, array_merge($headers, [
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]));
    }
}
