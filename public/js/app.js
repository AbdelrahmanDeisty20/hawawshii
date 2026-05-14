// ===== APP DATA (Static for now, can be fetched from API later) =====
const DEFAULT_SETTINGS = {
  productName: 'لقمة حواوشي',
  unitPrice: 55,
  discountedPrice: 45,
  discountQtyThreshold: 5,
  whatsappNumber: '201064059604',
  areas: [
    { name: 'وسط المنصورة', delivery: 10, active: true },
    { name: 'ميت خميس', delivery: 12, active: true },
    { name: 'طلخا', delivery: 15, active: true },
    { name: 'شبرا بخوم', delivery: 15, active: true },
    { name: 'السنبلاوين', delivery: 20, active: true },
    { name: 'ديرب نجم', delivery: 20, active: true },
    { name: 'المطرية', delivery: 25, active: true },
  ],
  reviews: [
    { name: 'أحمد سامي', location: 'وسط المنصورة', rating: 5, text: 'والله جربته في رمضان وأبهرني! الطعم زي اللي بنشتريه من المحل بالظبط، بس أسهل بكتير. هطلبه دايمًا 🔥' },
    { name: 'سارة محمود', location: 'طلخا', rating: 5, text: 'عملته في الفرن والأولاد اتجننوا بيه. اللحمة طازجة جدًا والتوابل تحفة! التوصيل كان سريع جدًا.' },
    { name: 'محمد الشاذلي', location: 'ميت خميس', rating: 5, text: 'أفضل حواوشي جاهز جربته. مناسب جدًا للسحور في رمضان، 10 دقايق وجاهز. عامل طلبية تانية دلوقتي 😄' },
    { name: 'هدى عبد الرحمن', location: 'المنصورة', rating: 4, text: 'منتج ممتاز والتغليف محترم. نصيحتي اعمليه على الشواية أحسن من الفرن، الطعم يبقى خرافي!' },
  ],
  faqs: [
    { q: 'هل المنتج مجمد؟', a: 'المنتج يُحفظ في الثلاجة أو الفريزر. يُنصح بتسخينه مباشرة من الثلاجة لأفضل طعم.' },
    { q: 'كام مدة التسوية في الفرن؟', a: 'في الفرن من 12 إلى 15 دقيقة على 180°. في الطاسة من 6 إلى 8 دقايق. في الشواية حسب الحرارة من 8 إلى 12 دقيقة.' },
    { q: 'ينفع يتعمل في الطاسة؟', a: 'أيوه بالطبع! الطاسة من أسهل الطرق — دهّن الطاسة بشوية زيت وسخّن على نار متوسطة.' },
    { q: 'اللحمة بلدي فعلًا؟', a: 'نعم 100%! نستخدم لحمة بلدي طازجة من مصادر موثوقة بدون أي إضافات صناعية.' },
    { q: 'إيه أنواع العروض المتاحة؟', a: 'عند طلب 5 قطع أو أكثر بتستمتع بسعر مخفض خاص. تابعونا على واتساب لمعرفة أحدث العروض!' },
  ],
};

const S = DEFAULT_SETTINGS;
let qty = 1;

// ===== AJAX CSRF SETUP =====
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// ===== POPULATE AREAS =====
function populateAreas() {
  const group = document.getElementById('areasGroup');
  if(!group) return;
  group.innerHTML = '';
  S.areas.filter(a => a.active).forEach(area => {
    const opt = document.createElement('option');
    opt.value = area.name;
    opt.dataset.delivery = area.delivery;
    opt.textContent = `${area.name} (توصيل ${area.delivery} جنيه)`;
    group.appendChild(opt);
  });
}

// ===== PRICE CALC =====
function getUnitPrice() {
  return qty >= S.discountQtyThreshold ? S.discountedPrice : S.unitPrice;
}
function getDelivery() {
  const sel = document.getElementById('areaSelect');
  const opt = sel.options[sel.selectedIndex];
  if (!opt || !opt.dataset.delivery) return 0;
  return parseInt(opt.dataset.delivery) || 0;
}
function updatePrices() {
  if(!document.getElementById('unitPrice')) return;
  const up = getUnitPrice();
  const del = getDelivery();
  const sub = up * qty;
  const tot = sub + del;
  document.getElementById('unitPrice').textContent = up + ' جنيه';
  document.getElementById('pqty').textContent = qty;
  document.getElementById('subtotal').textContent = sub + ' جنيه';
  document.getElementById('deliveryFee').textContent = del > 0 ? del + ' جنيه' : '—';
  document.getElementById('total').textContent = del > 0 ? tot + ' جنيه' : sub + ' جنيه + التوصيل';
  document.getElementById('offerBadge').classList.toggle('show', qty >= S.discountQtyThreshold);
}
function changeQty(d) {
  qty = Math.max(1, Math.min(99, qty + d));
  document.getElementById('qtyDisplay').textContent = qty;
  updatePrices();
}

// ===== AREA CHANGE =====
function handleAreaChange() {
  const sel = document.getElementById('areaSelect');
  const val = sel.value;
  const isOutside = val === 'outside';
  document.getElementById('outsideNote').classList.toggle('show', isOutside);
  document.getElementById('addressGroup').style.display = isOutside ? 'none' : '';
  document.getElementById('submitBtn').style.display = isOutside ? 'none' : '';
  updatePrices();
}

// ===== VALIDATE & SUBMIT =====
function validateForm() {
  let ok = true;
  const name = document.getElementById('custName').value.trim();
  const phone = document.getElementById('custPhone').value.trim();
  const area = document.getElementById('areaSelect').value;
  const addr = document.getElementById('custAddress').value.trim();
  document.getElementById('nameErr').style.display = name ? 'none' : 'block'; if (!name) ok = false;
  const phoneOk = /^(010|011|012|015)\d{8}$/.test(phone);
  document.getElementById('phoneErr').style.display = phoneOk ? 'none' : 'block'; if (!phoneOk) ok = false;
  document.getElementById('areaErr').style.display = (area && area !== 'outside') ? 'none' : 'block'; if (!area || area === 'outside') ok = false;
  document.getElementById('addrErr').style.display = addr ? 'none' : 'block'; if (!addr) ok = false;
  return ok;
}

function submitOrder() {
  if (!validateForm()) { document.querySelector('.order-box').scrollIntoView({behavior:'smooth',block:'center'}); return; }
  
  const submitBtn = document.getElementById('submitBtn');
  submitBtn.disabled = true;
  submitBtn.innerHTML = 'جاري المعالجة...';

  const name = document.getElementById('custName').value.trim();
  const phone = document.getElementById('custPhone').value.trim();
  const area = document.getElementById('areaSelect').value;
  const addr = document.getElementById('custAddress').value.trim();
  const notes = document.getElementById('custNotes').value.trim();
  const up = getUnitPrice();
  const del = getDelivery();
  const tot = up * qty + del;

  $.ajax({
      url: '/order',
      method: 'POST',
      data: {
          name: name,
          phone: phone,
          area: area,
          address: addr,
          notes: notes,
          quantity: qty,
          total_price: tot
      },
      success: function(response) {
          const msg = `🥙 *طلب جديد — لقمة حواوشي*\n\n👤 الاسم: ${name}\n📱 الهاتف: ${phone}\n📍 المنطقة: ${area}\n🏠 العنوان: ${addr}\n📦 الكمية: ${qty} قطعة\n💰 السعر: ${up} جنيه / قطعة\n🚚 التوصيل: ${del} جنيه\n💵 *الإجمالي: ${tot} جنيه*${notes ? '\n📝 ملاحظات: ' + notes : ''}\n\n⏰ ${new Date().toLocaleString('ar-EG')}`;
          const waUrl = `https://wa.me/${S.whatsappNumber}?text=${encodeURIComponent(msg)}`;
          
          Swal.fire({
              icon: 'success',
              title: 'تم استلام طلبك!',
              text: response.message,
              confirmButtonText: 'حسنًا',
              timer: 3000
          }).then(() => {
              window.open(waUrl, '_blank');
              location.reload();
          });
      },
      error: function(xhr) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<span>📲</span> أرسل طلبك على واتساب';
          let errorMsg = 'حدث خطأ ما، يرجى المحاولة لاحقاً.';
          if (xhr.status === 422) {
              const errors = xhr.responseJSON.errors;
              errorMsg = Object.values(errors).flat().join('<br>');
          }
          Swal.fire({
              icon: 'error',
              title: 'خطأ!',
              html: errorMsg,
          });
      }
  });
}

// ===== ZONE REGISTRATION =====
function submitZoneRegistration() {
  const name = document.getElementById('zoneName').value.trim();
  const phone = document.getElementById('zonePhone').value.trim();
  const area = document.getElementById('zoneArea').value.trim();
  
  if (!name || !phone || !area) { 
      Swal.fire({ icon: 'warning', text: 'من فضلك اكمل بياناتك' });
      return; 
  }

  $.ajax({
      url: '/zone-registration',
      method: 'POST',
      data: { name, phone, area },
      success: function(response) {
          closeModal('zoneModal');
          Swal.fire({
              icon: 'success',
              title: 'تم التسجيل!',
              text: response.message
          });
      },
      error: function() {
          Swal.fire({ icon: 'error', text: 'حدث خطأ أثناء التسجيل.' });
      }
  });
}

// ===== REVIEWS =====
function renderReviews() {
  const grid = document.getElementById('reviewsGrid');
  if(!grid) return;
  grid.innerHTML = S.reviews.map(r => `
    <div class="review-card fade-up">
      <div class="stars">${'★'.repeat(r.rating)}${'☆'.repeat(5-r.rating)}</div>
      <div class="review-text">${r.text}</div>
      <div class="reviewer">
        <div class="reviewer-avatar">${r.name[0]}</div>
        <div>
          <div class="reviewer-name">${r.name}</div>
          <div class="reviewer-loc">📍 ${r.location}</div>
        </div>
      </div>
    </div>`).join('');
}

// ===== FAQ =====
function renderFAQ() {
  const list = document.getElementById('faqList');
  if(!list) return;
  list.innerHTML = S.faqs.map((f, i) => `
    <div class="faq-item" id="faqItem${i}">
      <div class="faq-q" onclick="toggleFAQ(${i})">
        <span>${f.q}</span>
        <span class="faq-icon">+</span>
      </div>
      <div class="faq-a">${f.a}</div>
    </div>`).join('');
}
function toggleFAQ(i) {
  const item = document.getElementById('faqItem'+i);
  document.querySelectorAll('.faq-item').forEach((el, j) => { if (j !== i) el.classList.remove('open'); });
  item.classList.toggle('open');
}

// ===== MODAL LOGIC =====
function openZoneModal() { document.getElementById('zoneModal').classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }

// ===== FLOATING BTN =====
function updateFloatBtn() {
  const orderSection = document.getElementById('order');
  if(!orderSection) return;
  const orderTop = orderSection.getBoundingClientRect().top;
  document.getElementById('floatOrder').classList.toggle('hidden', orderTop < window.innerHeight && orderTop > -200);
}

// ===== INIT =====
document.addEventListener('DOMContentLoaded', () => {
  populateAreas();
  updatePrices();
  renderReviews();
  renderFAQ();
  
  // Intersection Observer for animations
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
  }, { threshold: 0.1 });
  document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

  window.addEventListener('scroll', updateFloatBtn);

  // Close modals on overlay click
  document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) el.classList.remove('show'); });
  });
});
