@extends('layouts.admin')
@section('title', 'الأسئلة الشائعة')
@section('page_title', 'إدارة الأسئلة الشائعة')

@section('content')
<div class="section-card">
    <div class="card-title">إضافة سؤال جديد</div>
    <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>السؤال</label>
            <input type="text" name="question" required>
        </div>
        <div class="form-group">
            <label>الإجابة</label>
            <textarea name="answer" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label>الترتيب</label>
            <input type="number" name="order" value="1">
        </div>
        <button type="submit" class="save-btn">+ إضافة السؤال</button>
    </form>

    <div class="table-wrap" style="margin-top: 30px;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>السؤال</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faqs as $faq)
                <tr>
                    <td>{{ $faq->order }}</td>
                    <td>{{ $faq->question }}</td>
                    <td>
                        <form action="{{ route('admin.faqs.delete', $faq->id) }}" method="POST" onsubmit="return confirm('حذف؟')">
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
