<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    // ===== LOGIN =====
    public function loginForm()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $user = config('admin.username', 'admin');
        $pass = config('admin.password', 'hawashi2024');

        if ($request->username === $user && $request->password === $pass) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login' => 'اسم المستخدم أو كلمة المرور غير صحيحة']);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    // ===== DASHBOARD =====
    public function dashboard()
    {
        $orders      = Order::latest()->get();
        $totalOrders = $orders->count();
        $todayOrders = $orders->filter(fn($o) => $o->created_at->isToday())->count();
        $totalRev    = $orders->where('status', 'delivered')->sum('total_price');
        $topQty      = $orders->groupBy('quantity')->map->count()->sortDesc()->keys()->first() ?? '—';

        return view('admin.dashboard', compact('orders', 'totalOrders', 'todayOrders', 'totalRev', 'topQty'));
    }

    // ===== ORDERS =====
    public function orders(Request $request)
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

    public function deleteOrder(Order $order)
    {
        $order->delete();
        return response()->json(['ok' => true]);
    }

    public function clearOrders()
    {
        Order::truncate();
        return response()->json(['ok' => true]);
    }

    public function exportOrders()
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
