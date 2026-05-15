@extends('layouts.admin')
@section('title', 'الأسعار والواتساب')
@section('page_title', 'إعدادات الأسعار والتواصل')

@section('content')
<div class="section-card">
    @if(session('success'))
        <div style="background: var(--green-light); color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="card-title">إعدادات الأسعار</div>
        <div class="form-group">
            <label>سعر القطعة الأساسي</label>
            <input type="number" name="unit_price" value="{{ $settings['unit_price'] ?? 55 }}">
        </div>
        <div class="form-group">
            <label>السعر المخفض</label>
            <input type="number" name="discounted_price" value="{{ $settings['discounted_price'] ?? 45 }}">
        </div>
        <div class="form-group">
            <label>حد الخصم (عدد القطع)</label>
            <input type="number" name="discount_threshold" value="{{ $settings['discount_threshold'] ?? 5 }}">
        </div>
        
        <div class="card-title" style="margin-top: 30px;">نصوص الموقع</div>
        <div class="form-group">
            <label>بنر التوصيل (شريط العلوي)</label>
            <input type="text" name="delivery_note" value="{{ $settings['delivery_note'] ?? '' }}">
        </div>
        <div class="form-group">
            <label>شارة الهيرو (Badge)</label>
            <input type="text" name="hero_badge" value="{{ $settings['hero_badge'] ?? '' }}">
        </div>
        <div class="form-group">
            <label>عنوان الهيرو</label>
            <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}">
        </div>
        <div class="form-group">
            <label>وصف الهيرو</label>
            <textarea name="hero_desc" rows="2">{{ $settings['hero_desc'] ?? '' }}</textarea>
        </div>

        <div class="card-title" style="margin-top: 30px;">التواصل</div>
        <div class="form-group">
            <label>رقم الواتساب (مثال: 201010455010)</label>
            <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '201010455010' }}">
        </div>
        <button type="submit" class="save-btn">💾 حفظ التغييرات</button>
    </form>
</div>
@endsection
