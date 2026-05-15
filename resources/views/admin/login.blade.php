<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تسجيل دخول الأدمن — لقمة حواوشي</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@700;800&display=swap" rel="stylesheet">
<style>
:root {
  --brown-dark: #3D1F0A;
  --brown-mid: #6B3A1F;
  --orange: #E8621A;
  --orange-light: #F5894A;
  --beige: #F5E6C8;
  --white: #FFFFFF;
  --text-light: #7A5C3A;
  --border: rgba(160,82,45,0.2);
  --red: #D32F2F;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Cairo', sans-serif; direction: rtl; }

.login-wrap {
  min-height: 100vh; display: flex; align-items: center; justify-content: center;
  background: linear-gradient(135deg, var(--brown-dark) 0%, var(--brown-mid) 100%);
  padding: 20px;
}
.login-box {
  background: var(--white); border-radius: 24px; padding: 48px 36px;
  max-width: 380px; width: 100%;
  box-shadow: 0 24px 64px rgba(0,0,0,0.3);
  text-align: center;
}
.login-logo { font-family: 'Tajawal', sans-serif; font-size: 28px; font-weight: 800; color: var(--brown-dark); margin-bottom: 8px; }
.login-logo span { color: var(--orange); }
.login-sub { font-size: 14px; color: var(--text-light); margin-bottom: 32px; }
.login-field { margin-bottom: 16px; text-align: right; }
.login-field label { display: block; font-size: 13px; font-weight: 600; color: var(--brown-dark); margin-bottom: 6px; }
.login-field input {
  width: 100%; padding: 12px 16px; border: 2px solid var(--border);
  border-radius: 10px; font-size: 15px; font-family: 'Cairo', sans-serif;
  transition: border-color 0.2s;
}
.login-field input:focus { outline: none; border-color: var(--orange); }
.login-btn {
  width: 100%; background: linear-gradient(135deg, var(--orange), #FF7A2F);
  color: var(--white); padding: 14px; border-radius: 10px; border: none;
  font-size: 17px; font-weight: 700; margin-top: 8px; font-family: 'Cairo', sans-serif;
  box-shadow: 0 4px 16px rgba(232,98,26,0.3); cursor: pointer;
  transition: all 0.2s;
}
.login-btn:hover { transform: translateY(-2px); }
.login-err { color: var(--red); font-size: 13px; margin-top: 10px; background: rgba(211,47,47,0.08); padding: 10px; border-radius: 8px; }
</style>
</head>
<body>
<div class="login-wrap">
  <div class="login-box">
    <div class="login-logo">🥙 لقمة <span>حواوشي</span></div>
    <div class="login-sub">لوحة تحكم الأدمن</div>

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <div class="login-field">
        <label for="username">اسم المستخدم</label>
        <input type="text" id="username" name="username" placeholder="مثال: admin" autocomplete="username" required value="{{ old('username') }}">
      </div>
      <div class="login-field">
        <label for="password">كلمة المرور</label>
        <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
      </div>
      <button type="submit" class="login-btn">دخول ➤</button>

      @if($errors->has('login'))
        <div class="login-err">{{ $errors->first('login') }}</div>
      @endif
    </form>
  </div>
</div>
</body>
</html>
