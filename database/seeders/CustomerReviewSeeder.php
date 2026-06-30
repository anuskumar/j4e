<?php

namespace Database\Seeders;

use App\Models\CustomerReview;
use Illuminate\Database\Seeder;

class CustomerReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'customer_name' => 'Shonda Williams',
                'subtitle' => 'Concert-goer',
                'rating' => 5,
                'review_content' => 'I needed last-minute tickets to a sold-out concert and Just 4 Entertainment came through. Checkout was quick, my e-tickets arrived within minutes, and entry at the venue was completely smooth. Highly recommend!',
                'sort_order' => 1,
            ],
            [
                'customer_name' => 'Grant Mason',
                'subtitle' => 'Sports Fan',
                'rating' => 4.5,
                'review_content' => 'Found great seats for a big match at a fair price. The listing was clear about the section and row, and support answered my question before purchase. Tickets scanned without any issues at the gate.',
                'sort_order' => 2,
            ],
            [
                'customer_name' => 'Marion Scott',
                'subtitle' => 'Food Expo Attendee',
                'rating' => 5,
                'review_content' => 'Bought tickets for the Food Expo through J4E and everything was 100% genuine. The whole family got in without a hitch. Secure payment and a site I trust for live events now.',
                'sort_order' => 3,
            ],
            [
                'customer_name' => 'Leonard Bender',
                'subtitle' => 'Theatre Lover',
                'rating' => 4,
                'review_content' => 'First time buying resale tickets and I was nervous, but the process was straightforward. Tickets were valid, priced fairly, and the order confirmation had all the details I needed for a stress-free evening.',
                'sort_order' => 4,
            ],
            [
                'customer_name' => 'Cheryl Bostick',
                'subtitle' => 'Family Events',
                'rating' => 5,
                'review_content' => 'Purchased four tickets for a family day out. The site is easy to navigate, payment felt secure, and we received our tickets right away. Will use Just 4 Entertainment again for our next event.',
                'sort_order' => 5,
            ],
            [
                'customer_name' => 'Martin Belvin',
                'subtitle' => 'Repeat Customer',
                'rating' => 4.5,
                'review_content' => 'This is my third purchase this year. Every order has been reliable — real tickets, honest listings, and no surprises at the door. Exactly what you want from a ticket marketplace.',
                'sort_order' => 6,
            ],
        ];

        foreach ($reviews as $review) {
            CustomerReview::updateOrCreate(
                ['customer_name' => $review['customer_name']],
                array_merge($review, ['is_active' => true])
            );
        }
    }
}
