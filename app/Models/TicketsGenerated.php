<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketsGenerated extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'event_ticket_tickets';

    public const FULFILLMENT_PENDING = 'pending';

    public const FULFILLMENT_SOLD = 'sold';

    protected $fillable = ['seat_id', 'file', 'ticket_amount', 'fulfillment_status', 'is_sold'];

    public static function get_the_number_of_tickets($id){

        $data = TicketsGenerated::where('event_tickets',$id)->where('is_sold',0)->where('under_purchase_hold',0)->get();
        return $data;
    }

    /**
     * Sold ticket still awaiting fulfillment (pending upload / mark sold).
     */
    public function isPendingFulfillment(): bool
    {
        if ((int) $this->is_sold !== 1) {
            return false;
        }

        if ($this->fulfillment_status === self::FULFILLMENT_SOLD) {
            return false;
        }

        if ($this->fulfillment_status === self::FULFILLMENT_PENDING) {
            return true;
        }

        // Legacy rows without fulfillment_status.
        return empty($this->file);
    }

    public function fulfillmentLabel(): string
    {
        if ((int) $this->is_sold !== 1) {
            return 'Available';
        }

        return $this->isPendingFulfillment() ? 'Pending' : 'Sold';
    }

    public function fulfillmentBadgeClass(): string
    {
        if ((int) $this->is_sold !== 1) {
            return 'text-bg-secondary';
        }

        return $this->isPendingFulfillment() ? 'text-bg-warning' : 'text-bg-success';
    }

    /**
     * Release checkout holds that have exceeded the 15-minute window.
     */
    public static function releaseExpiredHolds(?int $eventTicketId = null): int
    {
        $validHoldStart = Carbon::now()->subMinutes(15);

        $query = self::where('under_purchase_hold', 1)
            ->where('is_sold', 0)
            ->where(function ($q) use ($validHoldStart) {
                $q->whereNull('purchase_hold_time')
                    ->orWhere('purchase_hold_time', '<', $validHoldStart);
            });

        if ($eventTicketId !== null) {
            $query->where('event_tickets', $eventTicketId);
        }

        return $query->update([
            'user_id' => null,
            'under_purchase_hold' => 0,
            'purchase_hold_time' => null,
        ]);
    }

    public function eventTicket()
    {
        return $this->belongsTo(EventTickets::class, 'event_tickets');
    }

    public function eventTiming()
    {
        return $this->belongsTo(EventTiming::class, 'event_timing');
    }
    public function outsideSell()
    {
        return $this->hasOne(OutsideSellModel::class, 'event_ticket_tickets_id', 'id');
    }
}
