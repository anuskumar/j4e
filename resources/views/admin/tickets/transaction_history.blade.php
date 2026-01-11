<?php $page = 'tickets/transaction-history'; ?>
@extends('admin.layout.app')
@section('admin_content')

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-0">Transaction History</h3>
                        <p class="text-muted mb-0 mt-1">
                            <strong>Event:</strong> {{ $event->event_name ?? 'N/A' }}
                        </p>
                    </div>
                    <a href="{{ url('tickets') }}" class="btn btn-primary">
                        <i class="far fa-arrow-left"></i> Back to Tickets
                    </a>
                </div>
                <div class="card-body">
                    @if($transactions->count() > 0)
                        <div class="table-responsive">
                            <table id="transaction-datatable" class="table table-striped table-hover table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center">Sl No</th>
                                        <th>Transaction ID</th>
                                        <th>Customer</th>
                                        <th>Ticket Type</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Currency</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Purchase Date</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>
                                            <strong>#{{ $transaction->purchase_id ?? 'N/A' }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $transaction->user_name ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $transaction->user_email ?? 'N/A' }}</small>
                                        </td>
                                        <td>{{ $transaction->ticket_name ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $transaction->ticket_count ?? 0 }} Tickets</span>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($transaction->payment_amount ?? 0, 2) }}</strong>
                                        </td>
                                        <td>{{ $transaction->currency_short ?? $transaction->currency_name ?? 'N/A' }}</td>
                                        <td>
                                            @if(isset($transaction->is_payment_completed))
                                                @if($transaction->is_payment_completed == 1)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->status_name)
                                                <span class="badge bg-primary">{{ $transaction->status_name }}</span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->created_at)
                                                {{ date('d-m-Y', strtotime($transaction->created_at)) }}<br>
                                                <small class="text-muted">{{ date('h:i A', strtotime($transaction->created_at)) }}</small>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <div class="table-action" style="display: flex; gap: 5px; flex-wrap: wrap; justify-content: center;">
                                                @if($transaction->purchase_id)
                                                    <a href="{{ url('view_invoice', $transaction->purchase_id) }}" 
                                                       class="btn btn-sm btn-success" 
                                                       title="View Invoice">
                                                        <i class="far fa-file-alt"></i> Invoice
                                                    </a>
                                                    <a href="{{ url('show_booking_details_show', $transaction->purchase_id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="View Details">
                                                        <i class="far fa-eye"></i> Details
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @if($transactions->count() > 0)
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Total Transactions:</strong></td>
                                        <td class="text-center"><strong>{{ $transactions->count() }}</strong></td>
                                        <td colspan="2"><strong>Total Amount:</strong> 
                                            {{ number_format($transactions->sum('payment_amount') ?? 0, 2) }}
                                            @if($transactions->first() && $transactions->first()->currency_short)
                                                {{ $transactions->first()->currency_short }}
                                            @endif
                                        </td>
                                        <td colspan="4"></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="far fa-info-circle fa-2x mb-3"></i>
                            <h5>No Transactions Found</h5>
                            <p class="mb-0">There are no transactions for this event yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <style>
        #transaction-datatable {
            width: 100%;
        }
        #transaction-datatable thead th {
            background-color: #4e73df;
            color: white;
            font-weight: 600;
            padding: 12px 8px;
            vertical-align: middle;
        }
        #transaction-datatable tbody td {
            padding: 10px 8px;
            vertical-align: middle;
        }
        #transaction-datatable tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge {
            font-size: 0.85em;
            padding: 0.35em 0.65em;
        }
    </style>

    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/js/main.js"></script>
    
    @include('datatable.datatable_js')
    
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('#transaction-datatable').DataTable({
                    order: [[0, 'desc']],
                    pageLength: 25,
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                });
            }
        });
    </script>

@endsection

