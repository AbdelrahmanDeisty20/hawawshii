<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // مسح كل الأسئلة القديمة عشان ميتكرروش
        DB::table('faqs')->truncate();

        $faqs = [
            [
                'order' => 1,
                'question' => 'هل المنتج مجمد؟',
                'answer' => 'المنتج يحفظ في الثلاجة أو الفريزر، يُنصح بتسخينه مباشرة من الثلاجة لأفضل طعم.'
            ],
            [
                'order' => 2,
                'question' => 'كام مدة التسوية في الفرن؟',
                'answer' => 'في الفرن من 12 إلى 15 دقيقة على 180°، في الطاسة من 6 إلى 8 دقايق، في الشواية حسب الحرارة من 8 إلى 12 دقيقة.'
            ],
            [
                'order' => 3,
                'question' => 'ينفع يتعمل في الطاسة؟',
                'answer' => 'أيوه بالطبع! الطاسة من أسهل الطرق — دهّن الطاسة بشوية زيت وسخّن على نار متوسطة.'
            ],
            [
                'order' => 4,
                'question' => 'اللحمة بلدي فعلاً؟',
                'answer' => 'نعم 100%! نستخدم لحمة بلدي طازجة من مصادر موثوقة بدون أي إضافات صناعية.'
            ],
            [
                'order' => 5,
                'question' => 'إيه أنواع العروض المتاحة؟',
                'answer' => 'عند طلب 5 قطع أو أكثر تستمتع بسعر مخفض خاص، تابعونا على واتساب لمعرفة أحدث العروض!'
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
