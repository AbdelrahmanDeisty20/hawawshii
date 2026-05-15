@extends('layouts.admin')
@section('title', 'التقييمات')
@section('page_title', 'إدارة تقييمات العملاء')

@section('content')
<div class="section-card">
    <div class="card-title">إضافة تقييم جديد</div>
    <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>اسم العميل</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>الموقع (اختياري)</label>
            <input type="text" name="location">
        </div>
        <div class="form-group">
            <label>التقييم</label>
            <select name="rating">
                <option value="5">⭐⭐⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
            </select>
        </div>
        <div class="form-group">
            <label>التعليق</label>
            <textarea name="comment" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label>صورة العميل</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <button type="submit" class="save-btn">+ إضافة التقييم</button>
    </form>

    <div class="table-wrap" style="margin-top: 30px;">
        <table>
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>الاسم</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr>
                    <td>
                        @if($review->image)
                            <img src="{{ asset('storage/' . $review->image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                        @else
                            👤
                        @endif
                    </td>
                    <td>{{ $review->name }}</td>
                    <td>
                        <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" onsubmit="return confirm('حذف؟')">
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
