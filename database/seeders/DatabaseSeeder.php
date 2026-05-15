<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,     // اليوزر الأدمن
            SettingSeeder::class,   // نصوص الموقع والأسعار
            FeatureSeeder::class,   // المميزات الستة
            StepSeeder::class,      // خطوات التحضير
            FaqSeeder::class,       // الأسئلة الشائعة
            // هعمل لك دول دلوقتي برضه عشان يكملوا معاك
            DeliveryAreaSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
