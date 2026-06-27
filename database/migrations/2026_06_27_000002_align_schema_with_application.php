<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Align legacy databases with the column names used by the application.
     */
    public function up(): void
    {
        $this->addUserColumns();
        $this->alignArtistTable();
        $this->alignEventBanksTable();
        $this->alignCurrencyTable();
        $this->alignCompanySettingsTable();
        $this->alignVenueTypeTable();
        $this->alignVenueTable();
        $this->alignVenueSeatingTable();
        $this->alignEventTable();
        $this->alignEventImagesTable();
        $this->alignEventTimingsTable();
        $this->alignTicketTypeTable();
        $this->alignTicketsRestrictionsTable();
        $this->alignSplitTypesTable();
        $this->alignMobileApplicationsTable();
        $this->alignEventTicketsTable();
        $this->alignEventTicketTicketsTable();
        $this->alignOrderStatusLogTable();
        $this->alignResellerFinalProccessTable();
        $this->alignEventReviewsTable();
        $this->alignSliderTable();
        $this->alignSellerPostalAddressTable();
    }

    public function down(): void
    {
        // Intentionally left empty — this migration only adds missing legacy columns.
    }

    private function addColumnIfMissing(string $table, string $column, callable $callback): void
    {
        if (! Schema::hasTable($table) || Schema::hasColumn($table, $column)) {
            return;
        }

        Schema::table($table, $callback);
    }

    private function renameColumnIfNeeded(string $table, string $from, string $to): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        if (Schema::hasColumn($table, $from) && ! Schema::hasColumn($table, $to)) {
            Schema::table($table, function (Blueprint $blueprint) use ($from, $to) {
                $blueprint->renameColumn($from, $to);
            });
        }
    }

    private function addUserColumns(): void
    {
        $this->addColumnIfMissing('users', 'country', fn (Blueprint $table) => $table->string('country')->nullable()->after('address'));
        $this->addColumnIfMissing('users', 'country_code', fn (Blueprint $table) => $table->string('country_code')->nullable()->after('country'));
        $this->addColumnIfMissing('users', 'profile', fn (Blueprint $table) => $table->string('profile')->nullable()->after('country_code'));
        $this->addColumnIfMissing('users', 'date_or_birth', fn (Blueprint $table) => $table->date('date_or_birth')->nullable()->after('profile'));
    }

    private function alignArtistTable(): void
    {
        $this->addColumnIfMissing('artist', 'contact_number', fn (Blueprint $table) => $table->string('contact_number')->nullable());
        $this->addColumnIfMissing('artist', 'about', fn (Blueprint $table) => $table->text('about')->nullable());
    }

    private function alignEventBanksTable(): void
    {
        $this->addColumnIfMissing('event_banks', 'resellerid', fn (Blueprint $table) => $table->unsignedBigInteger('resellerid')->nullable());
        $this->addColumnIfMissing('event_banks', 'bank_email', fn (Blueprint $table) => $table->string('bank_email')->nullable());
        $this->addColumnIfMissing('event_banks', 'bank_country', fn (Blueprint $table) => $table->string('bank_country')->nullable());
        $this->addColumnIfMissing('event_banks', 'accnt_no', fn (Blueprint $table) => $table->string('accnt_no')->nullable());
        $this->addColumnIfMissing('event_banks', 'bic', fn (Blueprint $table) => $table->string('bic')->nullable());
        $this->addColumnIfMissing('event_banks', 'comments', fn (Blueprint $table) => $table->text('comments')->nullable());
    }

    private function alignCurrencyTable(): void
    {
        $this->addColumnIfMissing('currency', 'currency_rate', fn (Blueprint $table) => $table->decimal('currency_rate', 10, 4)->nullable());
    }

    private function alignCompanySettingsTable(): void
    {
        $this->addColumnIfMissing('company_settings', 'user_id', fn (Blueprint $table) => $table->unsignedBigInteger('user_id')->nullable());
        $this->addColumnIfMissing('company_settings', 'company_website', fn (Blueprint $table) => $table->string('company_website')->nullable());
        $this->addColumnIfMissing('company_settings', 'company_footer_text', fn (Blueprint $table) => $table->text('company_footer_text')->nullable());
        $this->addColumnIfMissing('company_settings', 'company_about', fn (Blueprint $table) => $table->text('company_about')->nullable());
        $this->addColumnIfMissing('company_settings', 'contact_number', fn (Blueprint $table) => $table->string('contact_number')->nullable());
        $this->addColumnIfMissing('company_settings', 'company_logo_small', fn (Blueprint $table) => $table->string('company_logo_small')->nullable());
    }

    private function alignVenueTypeTable(): void
    {
        $this->renameColumnIfNeeded('venue_type', 'type_name', 'venue_type_name');
    }

    private function alignVenueTable(): void
    {
        $this->addColumnIfMissing('venue', 'google_map_link', fn (Blueprint $table) => $table->text('google_map_link')->nullable());
        $this->addColumnIfMissing('venue', 'latitude', fn (Blueprint $table) => $table->string('latitude')->nullable());
        $this->addColumnIfMissing('venue', 'longitude', fn (Blueprint $table) => $table->string('longitude')->nullable());
        $this->addColumnIfMissing('venue', 'image', fn (Blueprint $table) => $table->string('image')->nullable());
    }

    private function alignVenueSeatingTable(): void
    {
        $this->renameColumnIfNeeded('venue_seating', 'venue_id', 'venue');
        $this->renameColumnIfNeeded('venue_seating', 'seating_name', 'seating_type_name');
        $this->renameColumnIfNeeded('venue_seating', 'description', 'seating_type_desc');
        $this->addColumnIfMissing('venue_seating', 'seat_serial_prefix', fn (Blueprint $table) => $table->string('seat_serial_prefix')->nullable());
        $this->addColumnIfMissing('venue_seating', 'seat_serial_start', fn (Blueprint $table) => $table->integer('seat_serial_start')->nullable());
        $this->addColumnIfMissing('venue_seating', 'seat_serial_end', fn (Blueprint $table) => $table->integer('seat_serial_end')->nullable());
        $this->addColumnIfMissing('venue_seating', 'seating_image', fn (Blueprint $table) => $table->string('seating_image')->nullable());
    }

    private function alignEventTable(): void
    {
        $this->addColumnIfMissing('event', 'seller_fee_percent', fn (Blueprint $table) => $table->decimal('seller_fee_percent', 5, 2)->nullable());
        $this->addColumnIfMissing('event', 'customer_fee_percent', fn (Blueprint $table) => $table->decimal('customer_fee_percent', 5, 2)->nullable());
        $this->addColumnIfMissing('event', 'priority', fn (Blueprint $table) => $table->unsignedInteger('priority')->default(0));
    }

    private function alignEventImagesTable(): void
    {
        $this->renameColumnIfNeeded('event_images', 'event_id', 'event');
        $this->renameColumnIfNeeded('event_images', 'image_path', 'image');
    }

    private function alignEventTimingsTable(): void
    {
        $this->renameColumnIfNeeded('event_timings', 'start_time', 'from_time');
        $this->renameColumnIfNeeded('event_timings', 'end_time', 'to_time');
    }

    private function alignTicketTypeTable(): void
    {
        $this->renameColumnIfNeeded('ticket_type', 'type_name', 'ticket_type_name');
    }

    private function alignTicketsRestrictionsTable(): void
    {
        $this->addColumnIfMissing('tickets_restrictions', 'restrictions', fn (Blueprint $table) => $table->string('restrictions')->nullable());
    }

    private function alignSplitTypesTable(): void
    {
        $this->renameColumnIfNeeded('split_types', 'type_name', 'split_name');
    }

    private function alignMobileApplicationsTable(): void
    {
        $this->renameColumnIfNeeded('mobile_applications', 'app_name', 'name');
    }

    private function alignEventTicketsTable(): void
    {
        $this->addColumnIfMissing('event_tickets', 'image', fn (Blueprint $table) => $table->string('image')->nullable());
    }

    private function alignEventTicketTicketsTable(): void
    {
        $this->addColumnIfMissing('event_ticket_tickets', 'on_sale', fn (Blueprint $table) => $table->boolean('on_sale')->default(1));
        $this->addColumnIfMissing('event_ticket_tickets', 'ticket_serial_number', fn (Blueprint $table) => $table->string('ticket_serial_number')->nullable());
        $this->addColumnIfMissing('event_ticket_tickets', 'seat_number', fn (Blueprint $table) => $table->string('seat_number')->nullable());
        $this->addColumnIfMissing('event_ticket_tickets', 'seat_row', fn (Blueprint $table) => $table->string('seat_row')->nullable());
        $this->addColumnIfMissing('event_ticket_tickets', 'seat_prefix', fn (Blueprint $table) => $table->string('seat_prefix')->nullable());
        $this->addColumnIfMissing('event_ticket_tickets', 'seat_number_prefix', fn (Blueprint $table) => $table->string('seat_number_prefix')->nullable());
    }

    private function alignOrderStatusLogTable(): void
    {
        $this->addColumnIfMissing('order_status_log', 'remark', fn (Blueprint $table) => $table->text('remark')->nullable());
        $this->addColumnIfMissing('order_status_log', 'document', fn (Blueprint $table) => $table->string('document')->nullable());
    }

    private function alignResellerFinalProccessTable(): void
    {
        $this->addColumnIfMissing('reseller_final_proccess', 'card_name', fn (Blueprint $table) => $table->string('card_name')->nullable());
        $this->addColumnIfMissing('reseller_final_proccess', 'card_number', fn (Blueprint $table) => $table->string('card_number')->nullable());
        $this->addColumnIfMissing('reseller_final_proccess', 'card_cvv', fn (Blueprint $table) => $table->string('card_cvv')->nullable());
        $this->addColumnIfMissing('reseller_final_proccess', 'exp_month', fn (Blueprint $table) => $table->string('exp_month')->nullable());
        $this->addColumnIfMissing('reseller_final_proccess', 'card_year', fn (Blueprint $table) => $table->string('card_year')->nullable());
    }

    private function alignEventReviewsTable(): void
    {
        $this->renameColumnIfNeeded('event_reviews', 'rating', 'number_of_stars');
    }

    private function alignSliderTable(): void
    {
        $this->addColumnIfMissing('slider', 'meta_description', fn (Blueprint $table) => $table->text('meta_description')->nullable());
        $this->addColumnIfMissing('slider', 'eventid', fn (Blueprint $table) => $table->unsignedBigInteger('eventid')->nullable());
        $this->addColumnIfMissing('slider', 'slide_image', fn (Blueprint $table) => $table->string('slide_image')->nullable());
    }

    private function alignSellerPostalAddressTable(): void
    {
        $this->addColumnIfMissing('seller__postel_address', 'resellerid', fn (Blueprint $table) => $table->unsignedBigInteger('resellerid')->nullable());
        $this->addColumnIfMissing('seller__postel_address', 'postcode', fn (Blueprint $table) => $table->string('postcode')->nullable());
        $this->addColumnIfMissing('seller__postel_address', 'country', fn (Blueprint $table) => $table->string('country')->nullable());
    }
};
