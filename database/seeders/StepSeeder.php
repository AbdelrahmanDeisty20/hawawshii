<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Step;

class StepSeeder extends Seeder
{
    public function run(): void
    {
        $steps = [
            [
                'order' => 1,
                'title' => 'افتح الكيس',
                'description' => 'الحواوشي جاهز ومحضّر بالتوابل البلدي الأصيلة',
                'icon' => '📦'
            ],
            [
                'order' => 2,
                'title' => 'سخّن زي ما تحب',
                'description' => 'فرن 15 دقيقة — أو طاسة 8 دقايق — أو شواية لطعم مميز',
                'icon' => '🔥'
            ],
            [
                'order' => 3,
                'title' => 'استمتع بالطعم',
                'description' => 'الطعم البلدي الحقيقي في بيتك من غير تعب!',
                'icon' => '😋'
            ],
        ];

        foreach ($steps as $step) {
            Step::updateOrCreate(['title' => $step['title']], $step);
        }
    }
}
