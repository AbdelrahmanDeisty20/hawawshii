<script>
$(document).ready(function() {
    // إعدادات الـ CSRF لـ jQuery
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // دالة تحديث الحسابات (مبنية على السعر 30)
    function refreshCalculations() {
        const up = 30;
        const currentQty = parseInt($('#qtyDisplay').text());
        const total = up * currentQty;
        
        $('#unitPrice').text(up + ' جنيه');
        $('#pqty').text(currentQty);
        $('#subtotal').text(total + ' جنيه');
        $('#total').text(total + ' جنيه');
    }

    // أزرار الكمية
    $('.qty-btn.plus').on('click', function() {
        let val = parseInt($('#qtyDisplay').text());
        $('#qtyDisplay').text(val + 1);
        refreshCalculations();
    });

    $('.qty-btn.minus').on('click', function() {
        let val = parseInt($('#qtyDisplay').text());
        if (val > 1) {
            $('#qtyDisplay').text(val - 1);
            refreshCalculations();
        }
    });

    // التعامل مع تغيير المنطقة
    $('#areaSelect').on('change', function() {
        const isOutside = $(this).val() === 'outside';
        $('#outsideNote').toggleClass('show', isOutside);
        $('#addressGroup').toggle(!isOutside);
        $('#submitBtn').toggle(!isOutside);
    });

    // تنفيذ طلب الأوردر عبر AJAX
    $('#submitBtn').on('click', function(e) {
        e.preventDefault();

        // Validation يدوي سريع بـ jQuery
        let isValid = true;
        $('.error-msg').hide();

        if ($('#custName').val().trim() === '') { $('#nameErr').show(); isValid = false; }
        if (!/^(010|011|012|015)\d{8}$/.test($('#custPhone').val().trim())) { $('#phoneErr').show(); isValid = false; }
        if ($('#areaSelect').val() === '' || $('#areaSelect').val() === 'outside') { $('#areaErr').show(); isValid = false; }
        if ($('#custAddress').val().trim() === '') { $('#addrErr').show(); isValid = false; }

        if (!isValid) {
            $('html, body').animate({ scrollTop: $("#order").offset().top - 100 }, 500);
            return;
        }

        const btn = $(this);
        const originalText = btn.html();
        btn.prop('disabled', true).html('<span class="spinner">⌛</span> جاري الطلب...');

        const formData = {
            name: $('#custName').val().trim(),
            phone: $('#custPhone').val().trim(),
            area: $('#areaSelect').val(),
            address: $('#custAddress').val().trim(),
            notes: $('#custNotes').val().trim(),
            quantity: parseInt($('#qtyDisplay').text()),
            total_price: 30 * parseInt($('#qtyDisplay').text())
        };

        $.ajax({
            url: "{{ route('order.store') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                const waNumber = '201010455010';
                const msg = `🥙 *طلب جديد — لقمة حواوشي*\n\n👤 الاسم: ${formData.name}\n📱 الهاتف: ${formData.phone}\n📍 المنطقة: ${formData.area}\n🏠 العنوان: ${formData.address}\n📦 الكمية: ${formData.quantity} قطعة\n💵 *الإجمالي: ${formData.total_price} جنيه*${formData.notes ? '\n📝 ملاحظات: ' + formData.notes : ''}`;
                const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`;
                
                Swal.fire({
                    icon: 'success',
                    title: 'تم تسجيل طلبك بنجاح!',
                    text: 'سيتم توجيهك للواتساب الآن لإتمام الطلب.',
                    confirmButtonText: 'تمام',
                    timer: 2000
                }).then(() => {
                    window.open(waUrl, '_blank');
                    location.reload();
                });
            },
            error: function(xhr) {
                btn.prop('disabled', false).html(originalText);
                let errorMsg = 'عذراً، حدث خطأ أثناء إرسال الطلب.';
                if (xhr.status === 422) {
                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                Swal.fire({ icon: 'error', title: 'خطأ!', html: errorMsg });
            }
        });
    });

    // أول تشغيل للحسابات
    refreshCalculations();
});

// دالة تسجيل المنطقة (خارج المنصورة)
function submitZoneRegistration() {
    const data = {
        name: $('#zoneName').val().trim(),
        phone: $('#zonePhone').val().trim(),
        area: $('#zoneArea').val().trim()
    };
    
    if (!data.name || !data.phone || !data.area) {
        Swal.fire({ icon: 'warning', text: 'من فضلك اكمل بياناتك' });
        return;
    }

    $.ajax({
        url: "{{ route('zone.store') }}",
        method: 'POST',
        data: data,
        success: function(response) {
            $('#zoneModal').removeClass('show');
            Swal.fire({ icon: 'success', title: 'شكراً لك!', text: 'تم تسجيل منطقتك وسنتواصل معك قريباً.' });
        },
        error: function() {
            Swal.fire({ icon: 'error', text: 'حدث خطأ ما، حاول ثانية.' });
        }
    });
}
</script>
