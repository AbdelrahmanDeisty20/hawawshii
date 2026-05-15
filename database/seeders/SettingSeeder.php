<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'unit_price' => '55',
            'discounted_price' => '45',
            'discount_threshold' => '5',
            'whatsapp_number' => '201010455010',
            'hero_badge' => '🔥 الأكثر طلبًا في المنصورة',
            'hero_title' => 'لقمة حواوشي — الطعم البلدي الحقيقي',
            'hero_desc' => 'حواوشي جاهز على التسوية — اعمله في الفرن أو الطاسة أو الشواية في دقائق وهتحس إنك في المطعم!',
            'delivery_note' => '🚚 متاح حاليًا داخل المنصورة فقط — وقريبًا هنفتح فروع في مناطق جديدة إن شاء الله ✨',
            'footer_text' => 'الطعم البلدي الحقيقي — لحمة بلدي 100%',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
