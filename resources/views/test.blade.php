<?php $page="eventtype/list";?>
@extends('admin.layout.app')
@section('admin_content')

	<!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generated Tickets</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable"  class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th class="border-bottom-0">Serial Number</th>
                                    <th class="border-bottom-0">Seat Number</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Under Purchase Hold </th>
                                    <th class="border-bottom-0">Amount</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $val)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $val->ticket_serial_number }}</td>
                                    <td>{{ $val->seat_number_prefix }}</td>

                                    <td>{{ $val->is_sold == 1 ? "Sold" :"UnSold" }}</td>
                                    <td>{{ $val->under_purchase_hold == 1 ? "Hold" :"No" }}</td>
                                    <td>{{ $val->ticket_amount }}</td>


                                    <td>
                                        <form action="{{ url('generated_tickets/destroy',$val->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        {{-- <a href="{{url('eventtype/view',$val->id)}}"><button type="button" class="btn btn-primary">view</button></a> --}}
                                        {{-- <a href="{{url('generated_tickets/edit',$val->id)}}"><button type="button" class="btn btn-info">View</button></a> --}}
                                        {{-- <button type="submit" class="btn btn-danger show_confirm">Delete</button> --}}
                                        <a class="btn ripple btn-info" data-bs-target="#modaldemo3" data-bs-toggle="modal" href="#">View</a>

                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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



        <div class="modal" id="modaldemo3">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">View Ticket</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">

                         <div class="row">
                            <div class="col-md-12">
                                <h4>Ticket Number : 12345678</h4>
                            </div>
                            <hr style="width:750px">
                            <div class="col-md-12">
                                <h6>Ticket Type : E-Ticket</h6>
                            </div>
                            <hr style="width:750px">

                            <div class="col-md-12">
                                <h6 style="color:red;">Important Notification : </h6>
                            </div>
                            <div class="col-md-12">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,  </p><br>
                            </div>

                            <hr style="width:750px">
                            <div class="col-md-8">
                                <h6>Artist Name : Esther</h6>
                                <hr>
                              <div> <h6>Listed Tickets</h6></div>
                              <div class="row">
                                <div class="col-md-4">
                                        <div class="table">
                                                dsdssfsfsdfdsfdsfsd

                                        </div>
                                        <div>
                                            dsdssfsfsdfdsfdsfsd

                                        </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="table">
                                        dsdssfsfsdfdsfdsfsd

                                </div>
                                <div>
                                    dsdssfsfsdfdsfdsfsd

                            </div>
                                </div>

                              </div>


                            </div>

                            <div class="col-md-4" >
                                <h6>Event Details :</h6>
                                <hr>
                                <div>Event Location :</div>

                                 <div><i class="fa fa-map-marker" aria-hidden="true"></i>
                                 abhudhabi,uae
                                 </div>
                                 <hr>
                                <div>Event Time :</div>
                                    <div><i class="fa fa-calendar" aria-hidden="true"></i>

                                    Starts at:<br>
                                    jan 27,2024.19 GST
                                   </div>
                            </div>
                         </div>

                        </div>
					<div class="modal-footer">

					</div>
				</div>
			</div>
		</div>






            </div>
        </div>
    </div>
    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <!-- End Row -->


@include('datatable.datatable_js')
@endsection
