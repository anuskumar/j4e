<?php

namespace App\Services;

use App\Models\CompanySettings;
use App\Models\TicketPurchase;
use App\Models\TicketsGenerated;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseInvoiceService
{
    public function getInvoiceData(int $purchaseId): array
    {
        $settings = CompanySettings::first();

        $data = TicketPurchase::where('ticket_purchase.id', $purchaseId)
            ->leftjoin('countries', 'countries.id', 'shipping_country')
            ->leftjoin('event', 'event.id', 'ticket_purchase.event_id')
            ->leftjoin('currency', 'currency.id', 'ticket_purchase.payment_currency')
            ->leftjoin('purchase_status', 'purchase_status.id', 'ticket_purchase.purchase_status')
            ->select('*', 'ticket_purchase.id as id', 'currency.name as currency_name', 'currency.short_name as currency_short_name')
            ->firstOrFail();

        $data_list = TicketsGenerated::where('event_ticket_tickets.purchase_id', $purchaseId)
            ->leftjoin('ticket_purchase', 'ticket_purchase.id', 'event_ticket_tickets.purchase_id')
            ->leftjoin('countries', 'countries.id', 'shipping_country')
            ->leftjoin('event', 'event.id', 'ticket_purchase.event_id')
            ->leftjoin('currency', 'currency.id', 'ticket_purchase.payment_currency')
            ->leftjoin('event_timings', 'event_timings.id', 'event_ticket_tickets.event_timing')
            ->leftjoin('venue_seating', 'venue_seating.id', 'event_ticket_tickets.event_seating')
            ->select('*', 'event_ticket_tickets.id as id', 'currency.name as currency_name')
            ->get();

        $count = TicketsGenerated::where('purchase_id', $data->id)->count();
        $ticket = TicketsGenerated::where('purchase_id', $data->id)->first();

        return compact('settings', 'data', 'count', 'ticket', 'data_list');
    }

    public function generatePdf(int $purchaseId)
    {
        $invoiceData = $this->getInvoiceData($purchaseId);
        $pdf = Pdf::loadView('customer.invoice_pdf', $invoiceData);
        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    public function generatePdfBinary(int $purchaseId): string
    {
        return $this->generatePdf($purchaseId)->output();
    }

    public function getInvoiceFilename(int $purchaseId): string
    {
        return 'invoice-' . str_pad((string) $purchaseId, 6, '0', STR_PAD_LEFT) . '.pdf';
    }
}
