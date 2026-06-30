<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\OrderStatusUpdate;
use App\Models\PurchaseStatus;
use App\Models\TicketPurchase;
use App\Models\TicketsGenerated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return $this->renderOrderList($request, 'new');
    }

    public function old_list(Request $request)
    {
        return $this->renderOrderList($request, 'old');
    }

    protected function renderOrderList(Request $request, string $listType)
    {
        $query = $this->buildOrderQuery($listType);
        $this->applyOrderFilters($query, $request);

        if (Auth::user()->user_type !== 'superadmin') {
            $query->where('event_tickets.created_by', Auth::user()->id);
        }

        $data = $query->get();
        $this->attachEventDates($data);

        $isNewOrders = $listType === 'new';

        return view('admin.order.list', [
            'data' => $data,
            'events' => $this->getFilterEvents($listType),
            'filters' => $this->getFilterValues($request),
            'filterAction' => $isNewOrders ? route('admin.customer.neworder') : url('customer_order/old_list'),
            'pageTitle' => $isNewOrders ? 'New Orders' : 'Older Orders',
            'pageDescription' => $isNewOrders
                ? 'View and manage recent customer orders that are still in progress.'
                : 'View completed and archived customer orders.',
        ]);
    }

    protected function buildOrderQuery(string $listType): Builder
    {
        $query = TicketPurchase::query()
            ->leftJoin('countries', 'countries.id', 'ticket_purchase.shipping_country')
            ->leftJoin('event', 'event.id', 'ticket_purchase.event_id')
            ->leftJoin('event_tickets', 'event_tickets.id', 'ticket_purchase.event_ticket_id')
            ->leftJoin('currency', 'currency.id', 'ticket_purchase.payment_currency')
            ->leftJoin('purchase_status', 'purchase_status.id', 'ticket_purchase.purchase_status')
            ->leftJoin('users', 'users.id', 'ticket_purchase.user_id')
            ->select(
                'ticket_purchase.*',
                'ticket_purchase.id as id',
                'event.event_name',
                'event.event_from_date',
                'currency.name as currency_name',
                'currency.short_name',
                'purchase_status.status_name',
                'users.name as user_name'
            )
            ->orderBy('ticket_purchase.created_at', 'DESC');

        if ($listType === 'new') {
            $query->whereNotIn('ticket_purchase.purchase_status', [3, 6]);
        } else {
            $query->where(function (Builder $statusQuery) {
                $statusQuery->where('ticket_purchase.purchase_status', 3)
                    ->orWhere('ticket_purchase.purchase_status', 6);
            });
        }

        return $query;
    }

    protected function applyOrderFilters(Builder $query, Request $request): void
    {
        if ($request->filled('event_id')) {
            $query->where('ticket_purchase.event_id', $request->event_id);
        }

        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('ticket_purchase.is_payment_completed', (int) $request->payment_status);
        }

        if ($request->filled('booking_date_from')) {
            $query->whereDate('event.event_from_date', '>=', $request->booking_date_from);
        }

        if ($request->filled('booking_date_to')) {
            $query->whereDate('event.event_from_date', '<=', $request->booking_date_to);
        }

        if ($request->filled('event_date_from') || $request->filled('event_date_to')) {
            $query->whereIn('ticket_purchase.id', function ($subQuery) use ($request) {
                $subQuery->select('event_ticket_tickets.purchase_id')
                    ->from('event_ticket_tickets')
                    ->join('event_timings', 'event_timings.id', '=', 'event_ticket_tickets.event_timing')
                    ->whereNotNull('event_ticket_tickets.purchase_id');

                if ($request->filled('event_date_from')) {
                    $subQuery->whereDate('event_timings.event_date', '>=', $request->event_date_from);
                }

                if ($request->filled('event_date_to')) {
                    $subQuery->whereDate('event_timings.event_date', '<=', $request->event_date_to);
                }
            });
        }
    }

    protected function getFilterEvents(string $listType)
    {
        $query = Events::query()
            ->join('ticket_purchase', 'ticket_purchase.event_id', '=', 'event.id')
            ->select('event.id', 'event.event_name')
            ->distinct()
            ->orderBy('event.event_name');

        if ($listType === 'new') {
            $query->whereNotIn('ticket_purchase.purchase_status', [3, 6]);
        } else {
            $query->where(function ($statusQuery) {
                $statusQuery->where('ticket_purchase.purchase_status', 3)
                    ->orWhere('ticket_purchase.purchase_status', 6);
            });
        }

        if (Auth::user()->user_type !== 'superadmin') {
            $query->join('event_tickets', 'event_tickets.id', '=', 'ticket_purchase.event_ticket_id')
                ->where('event_tickets.created_by', Auth::user()->id);
        }

        return $query->get();
    }

    protected function getFilterValues(Request $request): array
    {
        return [
            'event_id' => $request->input('event_id', ''),
            'event_date_from' => $request->input('event_date_from', ''),
            'event_date_to' => $request->input('event_date_to', ''),
            'booking_date_from' => $request->input('booking_date_from', ''),
            'booking_date_to' => $request->input('booking_date_to', ''),
            'payment_status' => $request->input('payment_status', 'all'),
        ];
    }

    protected function attachEventDates($orders): void
    {
        foreach ($orders as $order) {
            $order->event_date = TicketsGenerated::query()
                ->leftJoin('event_timings', 'event_timings.id', '=', 'event_ticket_tickets.event_timing')
                ->where('event_ticket_tickets.purchase_id', $order->id)
                ->select(
                    'event_timings.event_date',
                    'event_timings.from_time as event_time'
                )
                ->first();
        }
    }

    public function update_order_status($id)
    {
        $data = TicketPurchase::where('ticket_purchase.id', $id)
            ->leftjoin('countries', 'countries.id', 'shipping_country')
            ->leftjoin('event', 'event.id', 'ticket_purchase.event_id')
            ->leftjoin('currency', 'currency.id', 'ticket_purchase.payment_currency')
            ->leftjoin('purchase_status', 'purchase_status.id', 'ticket_purchase.purchase_status')
            ->leftjoin('users', 'users.id', 'ticket_purchase.user_id')
            ->select('*', 'ticket_purchase.id as id', 'currency.name as currency_name', 'users.name as user_name')->first();

        $status = PurchaseStatus::get();

        $log = OrderStatusUpdate::where('order_status_log.purchase_id', $id)
            ->leftjoin('purchase_status', 'purchase_status.id', 'order_status_log.status_id')
            ->leftjoin('users', 'users.id', 'order_status_log.created_by')
            ->select('*', 'order_status_log.id as id')
            ->get();

        return view('admin.order.change_status', compact('data', 'status', 'log'));
    }

    public function order_status_change(Request $request)
    {
        $data = new OrderStatusUpdate();
        $data->purchase_id = $request->purchase_id;
        $data->status_id = $request->status_id;
        $data->remark = $request->remark;
        $data->created_by = Auth::user()->id;
        if ($request->hasFile('document')) {
            $imageName = time() . '.' . $request->document->extension();
            $request->document->move(storage_path('uploads/purchase_status_document'), $imageName);
            $data->document = $imageName;
        }
        $data->save();

        $purchase = TicketPurchase::find($request->purchase_id);
        $purchase->purchase_status = $request->status_id;
        $purchase->save();

        return back();
    }

    public function delete_status_log($id)
    {
        $data = OrderStatusUpdate::find($id);
        $data->delete();

        return back();
    }
}
