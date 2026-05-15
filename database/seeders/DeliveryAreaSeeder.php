<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryArea;
use Illuminate\Support\Facades\DB;

class DeliveryAreaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('delivery_areas')->truncate();
        
        $areas = [
            ['name' => 'حي الجامعة', 'delivery_fee' => 30],
            ['name' => 'احمد ماهر', 'delivery_fee' => 30],
            ['name' => 'توريل', 'delivery_fee' => 30],
            ['name' => 'المشاية السفلى ', 'delivery_fee' => 30],
            ['name' => 'جيهان', 'delivery_fee' => 30],
        ];

        foreach ($areas as $area) {
            DeliveryArea::create($area);
        }
    }
}
