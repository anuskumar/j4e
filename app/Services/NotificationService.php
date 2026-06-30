<?php

namespace App\Services;

use App\Models\AdminNotification;
use App\Models\EventTickets;
use App\Models\Events;
use App\Models\RequestEventModel;
use App\Models\TicketPurchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public const TYPE_NEW_ORDER = 'new_order';
    public const TYPE_EVENT_REQUEST = 'event_request';
    public const TYPE_NEW_EVENT = 'new_event';
    public const TYPE_NEW_TICKET = 'new_ticket';

    public function send(
        int $userId,
        string $type,
        string $title,
        ?string $message = null,
        ?string $link = null,
        ?int $referenceId = null,
        ?string $referenceType = null
    ): AdminNotification {
        return AdminNotification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'reference_id' => $referenceId,
            'reference_type' => $referenceType,
        ]);
    }

    public function sendToSuperadmins(
        string $type,
        string $title,
        ?string $message = null,
        ?string $link = null,
        ?int $referenceId = null,
        ?string $referenceType = null
    ): void {
        $adminIds = User::query()
            ->where('user_type', 'superadmin')
            ->pluck('id');

        foreach ($adminIds as $adminId) {
            $this->send($adminId, $type, $title, $message, $link, $referenceId, $referenceType);
        }
    }

    public function notifyNewOrder(
        TicketPurchase $purchase,
        string $eventName,
        string $customerName,
        int $resellerUserId
    ): void {
        $title = 'New Order #' . $purchase->id;
        $message = $customerName . ' placed an order for ' . $eventName;
        $link = url('customer_order/update_order_status/' . $purchase->id);

        $this->send(
            $resellerUserId,
            self::TYPE_NEW_ORDER,
            $title,
            $message,
            $link,
            $purchase->id,
            'ticket_purchase'
        );

        $this->sendToSuperadmins(
            self::TYPE_NEW_ORDER,
            $title,
            $message,
            route('admin.customer.neworder'),
            $purchase->id,
            'ticket_purchase'
        );
    }

    public function notifyEventRequest(RequestEventModel $request): void
    {
        $title = $request->name . ' requested a new event';
        $message = $request->event_details;
        $link = route('events.requestlist');

        $this->sendToSuperadmins(
            self::TYPE_EVENT_REQUEST,
            $title,
            $message,
            $link,
            $request->id,
            'event_request'
        );
    }

    public function notifyEventCreated(Events $event, ?User $creator = null): void
    {
        $creator ??= User::find($event->event_added_by);
        $creatorName = $creator ? ucfirst($creator->name) : 'Someone';
        $creatorLabel = ($creator && $creator->user_type === 'reseller') ? ' (Reseller)' : '';

        $this->sendToSuperadmins(
            self::TYPE_NEW_EVENT,
            'New Event: ' . $event->event_name,
            $creatorName . ' created a new event' . $creatorLabel,
            url('events/view/' . $event->id),
            $event->id,
            'event'
        );
    }

    public function notifyTicketCreated(EventTickets $ticket, ?User $creator = null): void
    {
        $creator ??= User::find($ticket->created_by);
        $creatorName = $creator ? ucfirst($creator->name) : 'Someone';
        $creatorLabel = ($creator && $creator->user_type === 'reseller') ? ' (Reseller)' : '';
        $eventName = Events::find($ticket->event)?->event_name ?? ('Event #' . $ticket->event);
        $ticketLabel = $ticket->ticket_name ?: ('Ticket #' . $ticket->id);
        $quantity = (int) ($ticket->no_of_tickets ?? 0);

        $this->sendToSuperadmins(
            self::TYPE_NEW_TICKET,
            'New Ticket: ' . $ticketLabel,
            $creatorName . ' listed ' . ($quantity ?: 'new') . ' ticket(s) for ' . $eventName . $creatorLabel,
            url('tickets/ticket_view/' . $ticket->id),
            $ticket->id,
            'event_tickets'
        );
    }

    public function getUnreadForUser(?User $user = null, int $limit = 10): Collection
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return collect();
        }

        $notifications = AdminNotification::query()
            ->where('user_id', $user->id)
            ->unread()
            ->latest()
            ->get()
            ->map(fn (AdminNotification $notification) => $this->formatNotificationItem($notification));

        if ($user->user_type === 'superadmin') {
            $legacyRequests = RequestEventModel::query()
                ->where('markas_read', 0)
                ->latest()
                ->get()
                ->map(fn (RequestEventModel $request) => $this->formatLegacyEventRequestItem($request));

            $notifications = $notifications->concat($legacyRequests);
        }

        return $notifications
            ->sortByDesc('created_at')
            ->take($limit)
            ->values();
    }

    public function getUnreadCount(?User $user = null): int
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return 0;
        }

        $count = AdminNotification::query()
            ->where('user_id', $user->id)
            ->unread()
            ->count();

        if ($user->user_type === 'superadmin') {
            $count += RequestEventModel::query()->where('markas_read', 0)->count();
        }

        return $count;
    }

    public function markAsRead(int $notificationId, ?User $user = null): bool
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return false;
        }

        $notification = AdminNotification::query()
            ->where('user_id', $user->id)
            ->whereKey($notificationId)
            ->first();

        if (!$notification) {
            return false;
        }

        $notification->markAsRead();

        return true;
    }

    public function openNotification(int $notificationId, ?User $user = null): ?string
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return null;
        }

        $notification = AdminNotification::query()
            ->where('user_id', $user->id)
            ->whereKey($notificationId)
            ->first();

        if (!$notification) {
            return null;
        }

        $notification->markAsRead();

        return $notification->link;
    }

    public function markAllAsRead(?User $user = null): void
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return;
        }

        AdminNotification::query()
            ->where('user_id', $user->id)
            ->unread()
            ->update(['read_at' => now()]);
    }

    public function iconForType(string $type): string
    {
        return match ($type) {
            self::TYPE_NEW_ORDER => 'la-shopping-cart text-primary',
            self::TYPE_EVENT_REQUEST => 'la-calendar-plus text-success',
            self::TYPE_NEW_EVENT => 'la-calendar text-success',
            self::TYPE_NEW_TICKET => 'la-ticket text-warning',
            default => 'la-bell text-info',
        };
    }

    public function iconBackgroundForType(string $type): string
    {
        return match ($type) {
            self::TYPE_NEW_ORDER => 'bg-primary-transparent',
            self::TYPE_EVENT_REQUEST => 'bg-success-transparent',
            self::TYPE_NEW_EVENT => 'bg-success-transparent',
            self::TYPE_NEW_TICKET => 'bg-warning-transparent',
            default => 'bg-info-transparent',
        };
    }

    protected function formatNotificationItem(AdminNotification $notification): object
    {
        return (object) [
            'id' => $notification->id,
            'source' => 'notification',
            'type' => $notification->type,
            'title' => $notification->title,
            'message' => $notification->message,
            'link' => $notification->link,
            'created_at' => $notification->created_at,
            'time_ago' => Carbon::parse($notification->created_at)->diffForHumans(),
            'icon' => $this->iconForType($notification->type),
            'icon_bg' => $this->iconBackgroundForType($notification->type),
        ];
    }

    protected function formatLegacyEventRequestItem(RequestEventModel $request): object
    {
        return (object) [
            'id' => $request->id,
            'source' => 'legacy_event_request',
            'type' => self::TYPE_EVENT_REQUEST,
            'title' => $request->name . ' added new event',
            'message' => $request->event_details,
            'link' => route('events.requestlist'),
            'created_at' => $request->created_at,
            'time_ago' => Carbon::parse($request->created_at)->diffForHumans(),
            'icon' => $this->iconForType(self::TYPE_EVENT_REQUEST),
            'icon_bg' => $this->iconBackgroundForType(self::TYPE_EVENT_REQUEST),
        ];
    }
}
