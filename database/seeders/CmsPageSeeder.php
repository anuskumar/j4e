<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => CmsPage::SLUG_TERMS,
                'title' => 'Terms and Conditions',
                'content' => '<h3>Welcome to Mastro Tickets</h3>
<p>These Terms and Conditions govern your use of our website and ticket marketplace services. By accessing or using our platform, you agree to these terms.</p>
<h4>1. Ticket Listings</h4>
<p>Sellers are responsible for the accuracy of their listings, including event details, seating information, and pricing. All tickets sold through the platform must be valid for the stated event.</p>
<h4>2. Purchases</h4>
<p>Buyers agree to provide accurate billing and contact information. Ticket prices are set by sellers and may be above or below face value.</p>
<h4>3. Fulfilment</h4>
<p>Tickets will be delivered according to the delivery method stated on the listing. Please review delivery timelines before completing your purchase.</p>
<h4>4. Changes</h4>
<p>We may update these Terms and Conditions from time to time. Continued use of the platform after changes are posted constitutes acceptance of the updated terms.</p>',
                'is_active' => 1,
            ],
            [
                'slug' => CmsPage::SLUG_PRIVACY,
                'title' => 'Privacy Policy',
                'content' => '<h3>Privacy Policy</h3>
<p>We respect your privacy and are committed to protecting your personal information. This policy explains how we collect, use, and safeguard data when you use our platform.</p>
<h4>Information We Collect</h4>
<p>We may collect account details, contact information, and transaction-related data needed to operate the marketplace and support your bookings.</p>
<h4>How We Use Information</h4>
<p>Your information is used to process orders, communicate about bookings, improve our services, and meet legal obligations.</p>
<h4>Contact</h4>
<p>If you have questions about this Privacy Policy, please contact our support team using the details shown on the website.</p>',
                'is_active' => 1,
            ],
        ];

        foreach ($pages as $page) {
            CmsPage::withTrashed()->updateOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'content' => $page['content'],
                    'is_active' => $page['is_active'],
                    'deleted_at' => null,
                ]
            );
        }
    }
}
