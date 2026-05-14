<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لقمة حواوشي — الطعم البلدي الحقيقي')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('css')
</head>
<body>

    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('js')
</body>
</html>
