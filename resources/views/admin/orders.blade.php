@extends('layouts.admin')

@section('title', 'جميع الطلبات')
@section('page_title', 'جميع الطلبات')

@section('content')
<div class="section-card">
    <div class="card-header">
        <div class="card-title">📦 إدارة الطلبات</div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.orders.export') }}" class="save-btn" style="background: var(--green);">تصدير CSV</a>
            <button onclick="clearAllOrders()" class="save-btn" style="background: var(--red);">حذف الكل</button>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.orders') }}" style="margin-bottom: 20px;">
        <select name="status" onchange="this.form.submit()" class="status-select" style="padding: 10px; width: 200px;">
            <option value="">كل الحالات</option>
            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>جديد</option>
            <option value="contact" {{ request('status') == 'contact' ? 'selected' : '' }}>جاري التواصل</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>تم التأكيد</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>تم التسليم</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
        </select>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>المنطقة</th>
                    <th>الكمية</th>
                    <th>الإجمالي</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr id="order-row-{{ $order->id }}">
                    <td>{{ $order->id }}</td>
                    <td><strong>{{ $order->name }}</strong><br><small>{{ $order->address }}</small></td>
                    <td><a href="tel:{{ $order->phone }}" style="color:var(--blue)">{{ $order->phone }}</a></td>
                    <td>{{ $order->area }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td style="font-weight:700;color:var(--orange)">{{ $order->total_price }} ج</td>
                    <td>
                        <select onchange="updateStatus({{ $order->id }}, this.value)" class="status-select">
                            <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>جديد</option>
                            <option value="contact" {{ $order->status == 'contact' ? 'selected' : '' }}>جاري التواصل</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>تم التأكيد</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                    </td>
                    <td>
                        <button onclick="deleteOrder({{ $order->id }})" style="color:var(--red); background:none; font-size:18px;">🗑️</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
function updateStatus(id, status) {
    $.post(`/admin/orders/${id}/status`, { status: status }, function(res) {
        if(res.ok) {
            Swal.fire({ icon: 'success', title: 'تم تحديث الحالة', timer: 1000, showConfirmButton: false });
        }
    });
}

function deleteOrder(id) {
    if(!confirm('هل أنت متأكد من حذف هذا الطلب؟')) return;
    $.ajax({
        url: `/admin/orders/${id}`,
        type: 'DELETE',
        success: function(res) {
            if(res.ok) {
                $(`#order-row-${id}`).fadeOut();
            }
        }
    });
}

function clearAllOrders() {
    if(!confirm('سيتم حذف جميع الطلبات نهائياً! هل أنت متأكد؟')) return;
    $.post('/admin/orders/clear', function(res) {
        if(res.ok) location.reload();
    });
}
</script>
@endsection
