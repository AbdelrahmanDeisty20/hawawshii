<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['title' => 'لحمة بلدي 100%', 'icon' => '🥩'],
            ['title' => 'محفوظ بأعلى جودة', 'icon' => '🏆'],
            ['title' => 'جاهز في دقائق', 'icon' => '⚡'],
            ['title' => 'فرن / طاسة / شواية', 'icon' => '🔥'],
            ['title' => 'مناسب للعزومات', 'icon' => '🎉'],
            ['title' => 'مثالي للسحور', 'icon' => '🌿'],
        ];

        foreach ($features as $feature) {
            Feature::updateOrCreate(['title' => $feature['title']], $feature);
        }
    }
}
