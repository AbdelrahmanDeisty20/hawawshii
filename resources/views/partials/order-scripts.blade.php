<script>
$(document).ready(function() {
    // إعدادات الـ CSRF لـ jQuery
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // إعدادات الأسعار الأصلية
    const S = {
        unitPrice: 55,
        discountedPrice: 45,
        discountQtyThreshold: 5
    };

    // دالة تحديث الحسابات
    function refreshCalculations() {
        const currentQty = parseInt($('#qtyDisplay').text());
        
        // حساب سعر القطعة بناء على الكمية (خصم للكميات)
        const up = currentQty >= S.discountQtyThreshold ? S.discountedPrice : S.unitPrice;
        
        // جلب سعر التوصيل من المنطقة المختارة
        const selectedArea = $('#areaSelect option:selected');
        const deliveryFee = parseInt(selectedArea.data('delivery')) || 0;
        
        const subtotal = up * currentQty;
        const total = subtotal + deliveryFee;
        
        // تحديث الواجهة
        $('#unitPrice').text(up + ' جنيه');
        $('#pqty').text(currentQty);
        $('#subtotal').text(subtotal + ' جنيه');
        
        const deliveryRow = $('#deliveryFee').parent();
        if (deliveryFee > 0) {
            $('#deliveryFee').text(deliveryFee + ' جنيه');
            deliveryRow.show();
        } else {
            $('#deliveryFee').text('—');
            // لا نخفي السطر هنا عشان اليوزر يشوف كلمة "توصيل"
            deliveryRow.show(); 
        }

        $('#total').text(total + ' جنيه');
        
        // إظهار شارة العرض لو انطبق الخصم
        if (currentQty >= S.discountQtyThreshold) {
            $('#offerBadge').addClass('show');
        } else {
            $('#offerBadge').removeClass('show');
        }
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
        refreshCalculations();
    });

    // تنفيذ طلب الأوردر عبر AJAX
    $('#submitBtn').on('click', function(e) {
        e.preventDefault();

        // Validation
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

        const currentQty = parseInt($('#qtyDisplay').text());
        const up = currentQty >= S.discountQtyThreshold ? S.discountedPrice : S.unitPrice;
        const deliveryFee = parseInt($('#areaSelect option:selected').data('delivery')) || 0;
        const total = (up * currentQty) + deliveryFee;

        const formData = {
            name: $('#custName').val().trim(),
            phone: $('#custPhone').val().trim(),
            area: $('#areaSelect').val(),
            address: $('#custAddress').val().trim(),
            notes: $('#custNotes').val().trim(),
            quantity: currentQty,
            total_price: total
        };

        $.ajax({
            url: "{{ route('order.store') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                const waNumber = '201010455010';
                const msg = `🥙 *طلب جديد — لقمة حواوشي*\n\n👤 الاسم: ${formData.name}\n📱 الهاتف: ${formData.phone}\n📍 المنطقة: ${formData.area}\n🏠 العنوان: ${formData.address}\n📦 الكمية: ${formData.quantity} قطعة\n💰 السعر: ${up} جنيه / قطعة\n🚚 التوصيل: ${deliveryFee} جنيه\n💵 *الإجمالي: ${total} جنيه*${formData.notes ? '\n📝 ملاحظات: ' + formData.notes : ''}`;
                const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`;
                
                Swal.fire({
                    icon: 'success',
                    title: 'تم تسجيل طلبك بنجاح! 🎉',
                    text: 'اضغط تمام عشان نبعت طلبك على الواتساب دلوقتي.',
                    confirmButtonText: 'تمام، ابعتني للواتساب',
                    confirmButtonColor: '#25D366',
                    timer: 4000,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = waUrl;
                });
            },
            error: function(xhr) {
                btn.prop('disabled', false).html(originalText);
                let errorMsg = 'عذراً، حدث خطأ أثناء إرسال الطلب. تأكد من اتصال قاعدة البيانات.';
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
