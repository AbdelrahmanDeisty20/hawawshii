@extends('layouts.admin')
@section('title', 'المناطق')
@section('page_title', 'إدارة مناطق التوصيل')

@section('content')
<div class="section-card">
    <div class="card-title">إضافة منطقة جديدة</div>
    <form action="{{ route('admin.areas.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 10px; align-items: end;">
            <div class="form-group">
                <label>اسم المنطقة</label>
                <input type="text" name="name" required placeholder="مثال: وسط المنصورة">
            </div>
            <div class="form-group">
                <label>سعر التوصيل</label>
                <input type="number" name="delivery_fee" required placeholder="15">
            </div>
            <button type="submit" class="save-btn" style="margin-bottom: 15px;">+ إضافة</button>
        </div>
    </form>

    <div class="table-wrap" style="margin-top: 20px;">
        <table>
            <thead>
                <tr>
                    <th>المنطقة</th>
                    <th>سعر التوصيل</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($areas as $area)
                <tr>
                    <td>{{ $area->name }}</td>
                    <td>{{ $area->delivery_fee }} ج</td>
                    <td>
                        <form action="{{ route('admin.areas.delete', $area->id) }}" method="POST" onsubmit="return confirm('حذف؟')">
                            @csrf @method('DELETE')
                            <button type="submit" style="color:var(--red); background:none; cursor:pointer;">🗑️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
