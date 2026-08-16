<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTickets extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_ACTIVE = 1;

    public const STATUS_PAUSED = 2;

    /** @deprecated Use STATUS_PAUSED */
    public const STATUS_POSTED = self::STATUS_PAUSED;

    public const STATUS_UNAPPROVED = 3;

    public const STATUS_SOLD = 4;

    public const STATUS_PENDING = 5;

    protected $table = 'event_tickets';
    protected $fillable = [
        'ticket_upload',
        'unique_id',
        'ticket_name',
        'ticket_type',
        'mobile_application_id',
        'event',
        'event_timing',
        'row',
        'seat_from',
        'seat_to',
        'no_of_tickets',
        'cover_image',
        'venue_seating',
        'ticket_amount',
        'face_value',
        'ticket_restrictions',
        'features',
        'amount_currency',
        'face_value_currency',
        'booking_expiry_date_time',
        'disclaimer_note',
        'cancellation_policy_notes',
        'map_layout',
        'is_admin_approved',
        'ticket_status',
        'split_type',
        'web_price',
        'seller_fee',
        'recive_perticket',
        'total_recive',
        'proof_of_id',
        'proof_of_purchase',
        'created_by',
    ];

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type');
    }

    public function eventTicketTickets()
    {
        return $this->hasMany(TicketsGenerated::class, 'event_tickets');
    }

    public function event()
    {
        return $this->belongsTo(Events::class, 'event');
    }

    public static function statusLabel(?int $status): string
    {
        return match ((int) $status) {
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_PAUSED => 'Paused',
            self::STATUS_UNAPPROVED => 'Unapproved',
            self::STATUS_SOLD => 'Sold',
            self::STATUS_PENDING => 'Pending',
            default => 'Unknown',
        };
    }

    public static function statusBadgeClass(?int $status): string
    {
        return match ((int) $status) {
            self::STATUS_ACTIVE => 'text-bg-success',
            self::STATUS_PAUSED => 'text-bg-secondary',
            self::STATUS_UNAPPROVED => 'text-bg-danger',
            self::STATUS_SOLD => 'text-bg-success',
            self::STATUS_PENDING => 'text-bg-warning',
            default => 'text-bg-secondary',
        };
    }

    public function canToggleActivePaused(): bool
    {
        if ((int) $this->is_admin_approved !== 1) {
            return false;
        }

        if (! in_array((int) $this->ticket_status, [self::STATUS_ACTIVE, self::STATUS_PAUSED], true)) {
            return false;
        }

        $availableCount = TicketsGenerated::where('event_tickets', $this->id)
            ->where('is_sold', 0)
            ->whereDoesntHave('outsideSell')
            ->count();

        return $availableCount > 0;
    }

    /**
     * Overall listing stays Active while any tickets are still available
     * or pending (sold but not yet uploaded/fulfilled).
     * Sold only when there are no available and no pending tickets left.
     */
    public static function syncSalesLifecycleStatus(int $listingId, bool $markSoldIfComplete = false): void
    {
        $listing = static::find($listingId);
        if (! $listing || (int) $listing->is_admin_approved !== 1) {
            return;
        }

        if ((int) $listing->ticket_status === self::STATUS_UNAPPROVED) {
            return;
        }

        $availableCount = TicketsGenerated::where('event_tickets', $listingId)
            ->where('is_sold', 0)
            ->whereDoesntHave('outsideSell')
            ->count();

        $pendingCount = TicketsGenerated::where('event_tickets', $listingId)
            ->where('is_sold', 1)
            ->whereDoesntHave('outsideSell')
            ->where(function ($query) {
                $query->where('fulfillment_status', TicketsGenerated::FULFILLMENT_PENDING)
                    ->orWhere(function ($legacy) {
                        $legacy->whereNull('fulfillment_status')
                            ->where(function ($fileQuery) {
                                $fileQuery->whereNull('file')
                                    ->orWhere('file', '');
                            });
                    });
            })
            ->count();

        $soldCount = TicketsGenerated::where('event_tickets', $listingId)
            ->where(function ($query) {
                $query->where('is_sold', 1)
                    ->orWhereHas('outsideSell');
            })
            ->count();

        // Available or pending tickets remain → listing stays Active.
        // Preserve Paused only while available tickets still exist.
        if ($availableCount > 0 || $pendingCount > 0) {
            if ($availableCount > 0 && (int) $listing->ticket_status === self::STATUS_PAUSED) {
                return;
            }

            if ((int) $listing->ticket_status !== self::STATUS_ACTIVE) {
                $listing->ticket_status = self::STATUS_ACTIVE;
                $listing->save();
            }

            return;
        }

        // Nothing available or pending.
        if ($soldCount === 0) {
            if (in_array((int) $listing->ticket_status, [self::STATUS_PENDING, self::STATUS_SOLD], true)) {
                $listing->ticket_status = self::STATUS_ACTIVE;
                $listing->save();
            }

            return;
        }

        $listing->ticket_status = ($markSoldIfComplete || (int) $listing->ticket_status === self::STATUS_SOLD)
            ? self::STATUS_SOLD
            : self::STATUS_PENDING;
        $listing->save();
    }

    public static function markPendingAfterPurchase(int $listingId): void
    {
        // Stay Active while available or pending-upload tickets remain.
        static::syncSalesLifecycleStatus($listingId, false);
    }

    public static function markSoldAfterFulfillment(int $listingId): void
    {
        // Sold only when there are no remaining available or pending tickets.
        static::syncSalesLifecycleStatus($listingId, true);
    }
}
