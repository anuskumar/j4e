<?php

namespace Database\Seeders;

use App\Models\CompanySettings;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySettingsSeeder extends Seeder
{
    /**
     * Seed default company settings used across admin and frontend layouts.
     */
    public function run(): void
    {
        $admin = User::where('user_type', 'superadmin')->first();

        CompanySettings::updateOrCreate(
            ['id' => 1],
            [
                'user_id' => $admin?->id,
                'company_name' => 'Mastro Tickets',
                'company_email' => 'info@just4entertainment.com',
                'company_website' => 'https://mastrotickets.com/',
                'company_footer_text' => 'Mastro Tickets is a secondary marketplace for live events.',
                'company_about' => 'All tickets are 100% guaranteed and secure. Prices are set by sellers and may be above or below face value.',
                'contact_number' => '+1 907 275 0477',
                'company_logo' => CompanySettings::DEFAULT_LOGO,
                'company_logo_small' => CompanySettings::DEFAULT_LOGO,
            ]
        );
    }
}
