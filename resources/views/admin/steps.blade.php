@extends('layouts.admin')
@section('title', 'التحضير')
@section('page_title', 'إدارة خطوات التحضير')

@section('content')
<div class="section-card">
    <div class="card-title">إضافة خطوة جديدة</div>
    <form action="{{ route('admin.steps.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>رقم الترتيب</label>
            <input type="number" name="order" value="1" required>
        </div>
        <div class="form-group">
            <label>عنوان الخطوة</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-group">
            <label>الوصف</label>
            <textarea name="description" rows="2" required></textarea>
        </div>
        <div class="form-group">
            <label>الأيقونة (Emoji)</label>
            <input type="text" name="icon">
        </div>
        <div class="form-group">
            <label>أو ارفع صورة</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <button type="submit" class="save-btn">+ إضافة</button>
    </form>

    <div class="table-wrap" style="margin-top: 30px;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الأيقونة/الصورة</th>
                    <th>العنوان</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($steps as $step)
                <tr>
                    <td>{{ $step->order }}</td>
                    <td>
                        @if($step->image)
                            <img src="{{ asset('storage/' . $step->image) }}" style="width: 30px;">
                        @else
                            {{ $step->icon }}
                        @endif
                    </td>
                    <td>{{ $step->title }}</td>
                    <td>
                        <form action="{{ route('admin.steps.delete', $step->id) }}" method="POST" onsubmit="return confirm('حذف؟')">
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
