<?php

namespace Database\Seeders;

use App\Models\CustomerReview;
use Illuminate\Database\Seeder;

class CustomerReviewSeeder extends Seeder
{
    public function run(): void
    {
        if (CustomerReview::count() > 0) {
            return;
        }

        $reviews = [
            [
                'customer_name' => 'Shonda Williams',
                'subtitle' => 'Engineering',
                'rating' => 3.2,
                'review_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.',
                'sort_order' => 1,
            ],
            [
                'customer_name' => 'Grant Mason',
                'subtitle' => 'Cultural',
                'rating' => 4.1,
                'review_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.',
                'sort_order' => 2,
            ],
            [
                'customer_name' => 'Marion Scott',
                'subtitle' => 'Computer',
                'rating' => 5,
                'review_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.',
                'sort_order' => 3,
            ],
            [
                'customer_name' => 'Leonard Bender',
                'subtitle' => 'Business',
                'rating' => 2,
                'review_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.',
                'sort_order' => 4,
            ],
            [
                'customer_name' => 'Cheryl Bostick',
                'subtitle' => 'Cultural',
                'rating' => 4,
                'review_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.',
                'sort_order' => 5,
            ],
            [
                'customer_name' => 'Martin Belvin',
                'subtitle' => 'Conference',
                'rating' => 4,
                'review_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.',
                'sort_order' => 6,
            ],
        ];

        foreach ($reviews as $review) {
            CustomerReview::create(array_merge($review, ['is_active' => true]));
        }
    }
}
