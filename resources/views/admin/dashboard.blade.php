@extends('layouts.admin')

@section('title', 'لوحة التحكم')
@section('page_title', 'لوحة التحكم')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div>
            <div class="stat-label">إجمالي الطلبات</div>
            <div class="stat-value">{{ $totalOrders }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🆕</div>
        <div>
            <div class="stat-label">طلبات اليوم</div>
            <div class="stat-value">{{ $todayOrders }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div>
            <div class="stat-label">إجمالي المبيعات</div>
            <div class="stat-value">{{ number_format($totalRev) }} ج</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🔥</div>
        <div>
            <div class="stat-label">الكمية الأكثر طلباً</div>
            <div class="stat-value">{{ $topQty }} قطع</div>
        </div>
    </div>
</div>

<div class="section-card">
    <div class="card-header">
        <div class="card-title">📦 آخر الطلبات</div>
        <a href="{{ route('admin.orders') }}" class="save-btn">عرض الكل</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>المنطقة</th>
                    <th>الكمية</th>
                    <th>الإجمالي</th>
                    <th>الحالة</th>
                    <th>الوقت</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders->take(5) as $order)
                <tr>
                    <td><strong>{{ $order->name }}</strong></td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->area }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td style="font-weight:700;color:var(--orange)">{{ $order->total_price }} ج</td>
                    <td>
                        <span class="badge badge-{{ $order->status }}">
                            {{ $order->status == 'new' ? 'جديد' : ($order->status == 'delivered' ? 'تم التسليم' : $order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
