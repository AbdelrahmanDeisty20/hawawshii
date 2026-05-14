// ===== GENERAL UI LOGIC =====
document.addEventListener('DOMContentLoaded', () => {
  // Intersection Observer for animations
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
  }, { threshold: 0.1 });
  document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

  // Floating Action Button visibility
  window.addEventListener('scroll', () => {
    const orderSection = document.getElementById('order');
    if(!orderSection) return;
    const orderTop = orderSection.getBoundingClientRect().top;
    const floatBtn = document.getElementById('floatOrder');
    if(floatBtn) floatBtn.classList.toggle('hidden', orderTop < window.innerHeight && orderTop > -200);
  });

  // Modal logic (overlay clicks)
  document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) el.classList.remove('show'); });
  });
});

// Modal Toggles
function openZoneModal() { document.getElementById('zoneModal').classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
