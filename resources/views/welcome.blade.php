@extends('layouts.app')

@section('content')

<!-- NAVBAR -->
<nav class="navbar">
  <div class="nav-logo">
    <span class="logo-icon">🥙</span>
    <span>لقمة حواوشي</span>
  </div>
  <a href="#order" class="nav-cta">اطلب الآن 🔥</a>
</nav>

<!-- DELIVERY BANNER -->
<div class="delivery-banner">
  <span>🚚 متاح حاليًا داخل المنصورة فقط — وقريبًا هنفتح فروع في مناطق جديدة إن شاء الله ✨</span>
</div>

<!-- HERO -->
<section class="hero" id="home">
  <div class="hero-content">
    <div class="hero-badge">🔥 الأكثر طلبًا في المنصورة</div>
    <div class="hero-image-wrap">
      <span class="hero-emoji">🥙</span>
    </div>
    <h1>لقمة <span class="accent">حواوشي</span><br>الطعم البلدي الحقيقي</h1>
    <p class="hero-desc">حواوشي جاهز على التسوية — اعمله في الفرن أو الطاسة أو الشواية في دقائق وهتحس إنك في المطعم!</p>
    <div class="hero-tags">
      <span class="hero-tag">🥩 لحمة بلدي 100%</span>
      <span class="hero-tag">⚡ جاهز للتسوية</span>
      <span class="hero-tag">🌿 مكونات طبيعية</span>
    </div>
    <a href="#order" class="hero-cta">اطلب دلوقتي 🛒</a>
  </div>
</section>

<!-- FEATURES -->
<section class="features section" id="features">
  <h2 class="section-title fade-up">ليه لقمة حواوشي؟</h2>
  <div class="divider"></div>
  <p class="section-subtitle fade-up">كل حاجة فيه بتخليك تطلبه تاني مرة</p>
  <div class="features-grid">
    <div class="feature-card fade-up">
      <div class="feature-icon">🥩</div>
      <div class="feature-title">لحمة بلدي 100%</div>
    </div>
    <div class="feature-card fade-up">
      <div class="feature-icon">🏆</div>
      <div class="feature-title">محفوظ بأعلى جودة</div>
    </div>
    <div class="feature-card fade-up">
      <div class="feature-icon">⚡</div>
      <div class="feature-title">جاهز في دقائق</div>
    </div>
    <div class="feature-card fade-up">
      <div class="feature-icon">🔥</div>
      <div class="feature-title">فرن / طاسة / شواية</div>
    </div>
    <div class="feature-card fade-up">
      <div class="feature-icon">🎉</div>
      <div class="feature-title">مناسب للعزومات</div>
    </div>
    <div class="feature-card fade-up">
      <div class="feature-icon">🌿</div>
      <div class="feature-title">مثالي للسحور</div>
    </div>
  </div>
</section>

<!-- HOW TO -->
<section class="howto section" id="howto">
  <h2 class="section-title fade-up">طريقة التحضير</h2>
  <div class="divider"></div>
  <p class="section-subtitle fade-up">أسهل من ما تتخيل!</p>
  <div class="steps">
    <div class="step fade-up">
      <div class="step-num">١</div>
      <div class="step-content">
        <h3>افتح الكيس</h3>
        <p>الحواوشي جاهز ومحضّر بالتوابل البلدي الأصيلة</p>
      </div>
      <div class="step-emoji">📦</div>
    </div>
    <div class="step fade-up">
      <div class="step-num">٢</div>
      <div class="step-content">
        <h3>سخّن زي ما تحب</h3>
        <p>فرن 15 دقيقة — أو طاسة 8 دقايق — أو شواية لطعم مميز</p>
      </div>
      <div class="step-emoji">🔥</div>
    </div>
    <div class="step fade-up">
      <div class="step-num">٣</div>
      <div class="step-content">
        <h3>استمتع بالطعم</h3>
        <p>الطعم البلدي الحقيقي في بيتك من غير تعب!</p>
      </div>
      <div class="step-emoji">😋</div>
    </div>
  </div>
</section>

<!-- ORDER -->
<section class="order section" id="order">
  <h2 class="section-title fade-up">اطلب دلوقتي</h2>
  <div class="divider"></div>
  <p class="section-subtitle fade-up">توصيل سريع لحد بيتك داخل المنصورة</p>

  <div class="order-box fade-up">
    <!-- Product -->
    <div class="order-product">
      <div class="order-product-img">🥙</div>
      <div>
        <div class="order-product-name">لقمة حواوشي</div>
        <div class="order-product-sub">لحمة بلدي 100% — جاهز للتسوية</div>
      </div>
    </div>

    <!-- Quantity -->
    <div class="qty-section">
      <div class="qty-label">الكمية:</div>
      <div class="qty-control">
        <button class="qty-btn minus" onclick="changeQty(-1)" aria-label="تقليل">−</button>
        <div class="qty-num" id="qtyDisplay">1</div>
        <button class="qty-btn plus" onclick="changeQty(1)" aria-label="زيادة">+</button>
      </div>
      <div class="offer-badge" id="offerBadge">🎉 عرض خاص! طلبت 5 قطع أو أكثر — السعر المخفض شغّال!</div>
    </div>

    <!-- Price breakdown -->
    <div class="price-breakdown">
      <div class="price-row"><span>سعر القطعة</span><span class="val" id="unitPrice">— جنيه</span></div>
      <div class="price-row"><span>الكمية</span><span class="val" id="pqty">1</span></div>
      <div class="price-row"><span>المنتجات</span><span class="val" id="subtotal">— جنيه</span></div>
      <div class="price-row"><span>رسوم التوصيل</span><span class="val" id="deliveryFee">— جنيه</span></div>
      <div class="price-row total"><span>الإجمالي</span><span class="val" id="total">— جنيه</span></div>
    </div>

    <!-- Customer form -->
    <div class="form-title">📋 بياناتك لإتمام الطلب</div>
    
    <div class="form-group">
      <label for="custName">الاسم الكريم *</label>
      <input type="text" id="custName" placeholder="اكتب اسمك هنا" maxlength="60">
      <div class="error-msg" id="nameErr">الاسم مطلوب</div>
    </div>
    <div class="form-group">
      <label for="custPhone">رقم الهاتف *</label>
      <input type="tel" id="custPhone" placeholder="01xxxxxxxxx" maxlength="11" inputmode="tel">
      <div class="error-msg" id="phoneErr">رقم هاتف صحيح مطلوب</div>
    </div>
    <div class="form-group">
      <label for="areaSelect">المنطقة *</label>
      <select id="areaSelect">
        <option value="">— اختر منطقتك —</option>
        <option value="حي الجامعة">حي الجامعة</option>
        <option value="جيهان">جيهان</option>
        <option value="أحمد ماهر">أحمد ماهر</option>
        <option value="المشاية السفلية">المشاية السفلية</option>
        <option value="توريل">توريل</option>
        <option value="outside">خارج المنصورة</option>
      </select>
      <div class="error-msg" id="areaErr">اختر منطقة من القائمة</div>
    </div>

    <!-- Outside area note -->
    <div class="outside-area-note" id="outsideNote">
      <strong>😊 شكرًا لاهتمامك!</strong><br>
      للأسف التوصيل متاح حاليًا داخل المنصورة فقط. سجّل منطقتك وهنتواصل معاك فور ما نفتح فرع قريب منك!
      <button class="register-zone-btn" onclick="openZoneModal()">سجّل منطقتك 📍</button>
    </div>
    <div class="form-group" id="addressGroup">
      <label for="custAddress">العنوان بالتفصيل *</label>
      <input type="text" id="custAddress" placeholder="الشارع، البناية، رقم الشقة..." maxlength="150">
      <div class="error-msg" id="addrErr">العنوان مطلوب</div>
    </div>
    <div class="form-group">
      <label for="custNotes">ملاحظات (اختياري)</label>
      <textarea id="custNotes" placeholder="أي تعليمات خاصة..."></textarea>
    </div>

    <button class="submit-btn" onclick="submitOrder()" id="submitBtn">
      <span>📲</span> أرسل طلبك على واتساب
    </button>
  </div>
</section>

<!-- REVIEWS -->
<section class="reviews section" id="reviews">
  <h2 class="section-title fade-up">آراء العملاء</h2>
  <div class="divider"></div>
  <p class="section-subtitle fade-up">ناس زيك جربوا وبقوا عملاء دايمين 😍</p>
  <div class="reviews-grid" id="reviewsGrid">
    <!-- Populated by JS -->
  </div>
</section>

<!-- FAQ -->
<section class="faq section" id="faq">
  <h2 class="section-title fade-up">أسئلة شائعة</h2>
  <div class="divider"></div>
  <div class="faq-list" id="faqList">
    <!-- Populated by JS -->
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-logo">🥙 لقمة حواوشي</div>
  <div>الطعم البلدي الحقيقي — لحمة بلدي 100%</div>
  <div>📍 متاح حاليًا داخل المنصورة</div>
  <div class="footer-note">© 2024 لقمة حواوشي — جميع الحقوق محفوظة</div>
</footer>

<!-- Float CTA -->
<a href="#order" class="float-order" id="floatOrder">
  🛒 اطلب الآن
</a>

<!-- Zone Registration Modal -->
<div class="modal-overlay" id="zoneModal">
  <div class="modal">
    <div class="modal-icon">📍</div>
    <div class="modal-title">سجّل منطقتك</div>
    <div class="modal-text">اكتب بياناتك وهنتواصل معاك فور ما نفتح في منطقتك!</div>
    <div class="zone-modal-form">
      <div class="form-group"><input type="text" id="zoneName" placeholder="اسمك الكريم"></div>
      <div class="form-group"><input type="tel" id="zonePhone" placeholder="رقم هاتفك" inputmode="tel"></div>
      <div class="form-group"><input type="text" id="zoneArea" placeholder="منطقتك / مدينتك"></div>
    </div>
    <button class="modal-btn" onclick="submitZoneRegistration()" style="width:100%;margin-bottom:10px">سجّل الآن ✅</button>
    <br>
    <button onclick="closeModal('zoneModal')" style="background:none;color:var(--text-light);font-size:14px;padding:8px">إغلاق</button>
  </div>
</div>

@include('partials.order-scripts')

@endsection
