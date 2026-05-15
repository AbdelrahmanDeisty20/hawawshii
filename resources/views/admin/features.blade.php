@extends('layouts.admin')
@section('title', 'المميزات')
@section('page_title', 'إدارة مميزات المنتج')

@section('content')
<div class="section-card">
    <div class="card-title">إضافة ميزة جديدة</div>
    <form action="{{ route('admin.features.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>عنوان الميزة</label>
            <input type="text" name="title" required placeholder="مثال: لحمة بلدي 100%">
        </div>
        <div class="form-group">
            <label>أيقونة (Emoji)</label>
            <input type="text" name="icon" placeholder="مثال: 🥩">
        </div>
        <div class="form-group">
            <label>أو ارفع صورة/أيقونة</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <button type="submit" class="save-btn">+ إضافة الميزة</button>
    </form>

    <div class="table-wrap" style="margin-top: 30px;">
        <table>
            <thead>
                <tr>
                    <th>الأيقونة/الصورة</th>
                    <th>العنوان</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($features as $feature)
                <tr>
                    <td>
                        @if($feature->image)
                            <img src="{{ asset('storage/' . $feature->image) }}" style="width: 30px;">
                        @else
                            <span style="font-size: 24px;">{{ $feature->icon }}</span>
                        @endif
                    </td>
                    <td>{{ $feature->title }}</td>
                    <td>
                        <form action="{{ route('admin.features.delete', $feature->id) }}" method="POST" onsubmit="return confirm('حذف؟')">
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
