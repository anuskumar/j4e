<?php

use App\Models\EventTickets;
use App\Models\TicketsGenerated;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Align existing listings with the new lifecycle statuses.
        EventTickets::query()
            ->where('is_admin_approved', 0)
            ->update(['ticket_status' => EventTickets::STATUS_UNAPPROVED]);

        EventTickets::query()
            ->where('is_admin_approved', 2)
            ->update(['ticket_status' => EventTickets::STATUS_UNAPPROVED]);

        EventTickets::query()
            ->where('is_admin_approved', 1)
            ->where(function ($query) {
                $query->whereNull('ticket_status')
                    ->orWhere('ticket_status', 0)
                    ->orWhere('ticket_status', 1);
            })
            ->update(['ticket_status' => EventTickets::STATUS_ACTIVE]);

        EventTickets::query()
            ->where('is_admin_approved', 1)
            ->where('ticket_status', 2)
            ->update(['ticket_status' => EventTickets::STATUS_POSTED]);

        $listingIds = EventTickets::query()->pluck('id');

        foreach ($listingIds as $listingId) {
            $soldCount = TicketsGenerated::where('event_tickets', $listingId)
                ->where(function ($query) {
                    $query->where('is_sold', 1)
                        ->orWhereExists(function ($sub) {
                            $sub->select(DB::raw(1))
                                ->from('outsidesell')
                                ->whereColumn('outsidesell.event_ticket_tickets_id', 'event_ticket_tickets.id');
                        });
                })
                ->count();

            $availableCount = TicketsGenerated::where('event_tickets', $listingId)
                ->where('is_sold', 0)
                ->whereNotExists(function ($sub) {
                    $sub->select(DB::raw(1))
                        ->from('outsidesell')
                        ->whereColumn('outsidesell.event_ticket_tickets_id', 'event_ticket_tickets.id');
                })
                ->count();

            if ($soldCount === 0) {
                continue;
            }

            EventTickets::where('id', $listingId)->update([
                'ticket_status' => $availableCount === 0
                    ? EventTickets::STATUS_SOLD
                    : EventTickets::STATUS_PENDING,
            ]);
        }
    }

    public function down(): void
    {
        // Irreversible data alignment.
    }
};
