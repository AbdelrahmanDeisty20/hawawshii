<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reviews')->truncate();

        $reviews = [
            ['name' => 'أحمد سامي', 'location' => 'وسط المنصورة', 'rating' => 5, 'comment' => 'والله جربته في رمضان وأبهرني!'],
            ['name' => 'سارة محمود', 'location' => 'طلخا', 'rating' => 5, 'comment' => 'عملته في الفرن والأولاد اتجننوا بيه.'],
            ['name' => 'محمد الشاذلي', 'location' => 'ميت خميس', 'rating' => 5, 'comment' => 'أفضل حواوشي جاهز جربته.'],
            ['name' => 'هدى عبد الرحمن', 'location' => 'المنصورة', 'rating' => 4, 'comment' => 'منتج ممتاز والتغليف محترم.'],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
