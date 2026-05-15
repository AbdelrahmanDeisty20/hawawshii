<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title') — لقمة حواوشي</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@700;800&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
:root {
  --brown-dark: #3D1F0A;
  --brown-mid: #6B3A1F;
  --brown-light: #A0522D;
  --orange: #E8621A;
  --orange-light: #F5894A;
  --green: #2D5A27;
  --green-light: #4A7C44;
  --beige: #F5E6C8;
  --beige-light: #FDF6E8;
  --cream: #FFFBF0;
  --white: #FFFFFF;
  --sidebar-bg: #1E0D00;
  --sidebar-item: rgba(255,255,255,0.07);
  --sidebar-active: rgba(232,98,26,0.3);
  --text-dark: #1A0A00;
  --text-light: #7A5C3A;
  --border: rgba(160,82,45,0.15);
  --shadow: 0 4px 20px rgba(61,31,10,0.12);
  --radius: 14px;
  --radius-sm: 10px;
  --red: #D32F2F;
  --yellow: #F59E0B;
  --blue: #2563EB;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Cairo', sans-serif; background: #F8F0E6; color: var(--text-dark); direction: rtl; }
a { text-decoration: none; color: inherit; }
button { cursor: pointer; border: none; font-family: inherit; }

/* LAYOUT */
.admin-layout { display: flex; min-height: 100vh; }
.sidebar {
  width: 240px; min-width: 240px;
  background: var(--sidebar-bg);
  display: flex; flex-direction: column;
  padding: 24px 0;
  position: fixed; top: 0; right: 0; bottom: 0;
  overflow-y: auto; z-index: 50;
  transition: transform 0.3s;
}
.sidebar-logo {
  font-family: 'Tajawal', sans-serif; font-size: 20px; font-weight: 800;
  color: var(--white); padding: 0 20px 24px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
  margin-bottom: 16px;
}
.sidebar-logo span { color: var(--orange-light); }
.nav-item {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 20px; color: rgba(255,255,255,0.65);
  font-size: 14px; font-weight: 600;
  cursor: pointer; transition: all 0.2s;
  border-radius: 8px; margin: 2px 12px;
}
.nav-item:hover { background: var(--sidebar-item); color: var(--white); }
.nav-item.active { background: var(--sidebar-active); color: var(--orange-light); }
.sidebar-logout { margin-top: auto; padding: 12px 20px; }
.logout-btn {
  width: 100%; background: rgba(211,47,47,0.15); color: #FF6B6B;
  border: 1px solid rgba(211,47,47,0.3); padding: 10px;
  border-radius: 8px; font-size: 14px; font-weight: 600;
  text-align: center;
}

.main-content {
  margin-right: 240px; flex: 1; padding: 28px;
  min-height: 100vh; overflow-x: hidden;
}
.topbar {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 28px;
}
.page-title { font-family: 'Tajawal', sans-serif; font-size: 26px; font-weight: 800; color: var(--brown-dark); }

/* STATS */
.stats-grid {
  display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 16px; margin-bottom: 28px;
}
.stat-card {
  background: var(--white); border-radius: var(--radius); padding: 22px 20px;
  box-shadow: var(--shadow); border: 1px solid var(--border);
  display: flex; align-items: center; gap: 16px;
}
.stat-icon { font-size: 36px; }
.stat-label { font-size: 13px; color: var(--text-light); font-weight: 600; margin-bottom: 4px; }
.stat-value { font-family: 'Tajawal', sans-serif; font-size: 28px; font-weight: 800; color: var(--brown-dark); }

/* SECTION CARD */
.section-card {
  background: var(--white); border-radius: var(--radius);
  padding: 24px; box-shadow: var(--shadow); border: 1px solid var(--border);
  margin-bottom: 24px;
}
.card-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 20px; padding-bottom: 14px;
  border-bottom: 1px solid var(--border);
}
.card-title { font-family: 'Tajawal', sans-serif; font-size: 18px; font-weight: 800; color: var(--brown-dark); }

/* TABLE */
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; font-size: 14px; }
th { background: var(--beige); padding: 12px 14px; text-align: right; font-weight: 700; color: var(--brown-mid); white-space: nowrap; border-bottom: 2px solid var(--border); }
td { padding: 12px 14px; border-bottom: 1px solid var(--border); vertical-align: middle; }
tr:hover td { background: rgba(245,230,200,0.3); }

.badge {
  display: inline-block; padding: 4px 12px; border-radius: 50px;
  font-size: 12px; font-weight: 700; white-space: nowrap;
}
.badge-new { background: rgba(37,99,235,0.12); color: var(--blue); }
.badge-contact { background: rgba(245,158,11,0.12); color: var(--yellow); }
.badge-confirmed { background: rgba(45,90,39,0.12); color: var(--green); }
.badge-delivered { background: rgba(45,90,39,0.2); color: var(--green-light); }
.badge-cancelled { background: rgba(211,47,47,0.1); color: var(--red); }

.status-select {
  border: 1px solid var(--border); border-radius: 8px; padding: 4px 8px;
  font-size: 13px; font-family: 'Cairo', sans-serif; cursor: pointer;
  background: var(--white);
}
.save-btn {
  background: linear-gradient(135deg, var(--orange), #FF7A2F);
  color: var(--white); padding: 10px 20px; border-radius: var(--radius-sm);
  font-size: 14px; font-weight: 700;
  box-shadow: 0 4px 14px rgba(232,98,26,0.3);
}

@media (max-width: 768px) {
  .sidebar { transform: translateX(100%); }
  .main-content { margin-right: 0; padding: 16px; }
}
</style>
</head>
<body>
<div class="admin-layout">
  <div class="sidebar">
    <div class="sidebar-logo">🥙 لقمة <span>حواوشي</span></div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 الرئيسية</a>
    <a href="{{ route('admin.orders') }}" class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">📦 الطلبات</a>
    
    <div class="sidebar-logout">
      <a href="{{ route('admin.logout') }}" class="logout-btn">🚪 خروج</a>
    </div>
  </div>

  <div class="main-content">
    <div class="topbar">
      <div class="page-title">@yield('page_title')</div>
    </div>
    @yield('content')
  </div>
</div>

<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});
</script>
@yield('scripts')
</body>
</html>
