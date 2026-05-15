@extends('layouts.admin')
@section('title', 'التتبع')
@section('page_title', 'إعدادات التتبع والـ Pixels')

@section('content')
<div class="section-card">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="card-title">إعدادات التتبع (Tracking)</div>
        <div class="form-group">
            <label>Facebook Pixel ID</label>
            <input type="text" name="fb_pixel" value="{{ $settings['fb_pixel'] ?? '' }}">
        </div>
        <div class="form-group">
            <label>TikTok Pixel ID</label>
            <input type="text" name="tiktok_pixel" value="{{ $settings['tiktok_pixel'] ?? '' }}">
        </div>
        <div class="form-group">
            <label>Google Tag Manager ID</label>
            <input type="text" name="gtm_id" value="{{ $settings['gtm_id'] ?? '' }}">
        </div>
        <button type="submit" class="save-btn">💾 حفظ الإعدادات</button>
    </form>
</div>
@endsection
