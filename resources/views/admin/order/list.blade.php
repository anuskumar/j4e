    <?php $page="order/list";?>
@extends(Auth::user()->user_type == "reseller" ? 'layouts.reseller_app' : 'admin.layout.app')
@if(Auth::user()->user_type == "reseller")

    @section('content')

@else
    @section('admin_content')
@endif


	<!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Basic Edit Table</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered border text-nowrap mb-0 dataTables" id="file-datatable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Event</th>
                                    <th>Event Date</th>
                                    <th>Booking Date</th>
                                    <th>Amount</th>
                                    <th>Purchased Date</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Customer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ url('show_details_show',@$val->event_id) }}">{{ @$val->event_name }} <span>{{ @$val->tag_name }}, {{ @$val->event_type_name }}</span></a>
                                    </td>
                                    <td>{{ @$val['event_date']->event_date }}<span class="d-block text-info">{{ @$val['event_date']->event_time }}</span></td>
                                    <td>{{ @$val->event_from_date }}</td>
                                    <td>{{ @$val->payment_amount }}
                                        {{ @$val->short_name }}
                                    </td>
                                    <td>{{date('d M Y',strtotime(@$val->created_at)) }}</td>
                                    <td>
                                       {{ @$val->status_name }}
                                    </td>
                                    <td>
                                        {{ @$val->is_payment_completed == 1 ? "Payment Completed" :"Not Completed"}}
                                    </td>
                                    <td>{{ $val->user_name }}</td>
                                    <td class="text-right">
                                        <div class="table-action">
                                            <a href="{{ url('view_invoice',@$val->id) }}" class="btn btn-sm bg-success-light" title="Invoice">
                                                <i class="far fa-file-alt"></i>
                                            </a>
                                            <a href="{{ url('show_booking_details_show',@$val->id) }}" class="btn btn-sm bg-success-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ url('customer_order/update_order_status',@$val->id) }}" class="btn btn-sm bg-success-light" title="Update Status">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                        {{-- </table> --}}
                        <div class="d-flex justify-content-center">
                        {{-- {!! $data->links() !!} --}}
                        </div>
                    </div>
                </div>

                {{-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          ...
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div> --}}








            </div>
        </div>
    </div>
    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/js/main.js"></script>
    <!-- End Row -->


@include('datatable.datatable_js')
@endsection
