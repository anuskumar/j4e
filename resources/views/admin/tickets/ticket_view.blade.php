<?php $page="eventtype/view";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label" >View EventType</div>
								<form class="form-horizontal">

                                    {{-- <div class="mb-4 main-content-label">Name</div> --}}


                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Ticket Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"  required   value="{{ $data ? $data->ticket_name : '' }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                {{-- {{ print_r($venue_type) }} --}}
                                                <label class="form-label">Ticket Type</label>
                                            </div>
                                            <div class="col-md-6">
                                           {{ $data->ticket_type_name }}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                {{-- {{ print_r($venue_type) }} --}}
                                                <label class="form-label">Event Timing</label>
                                            </div>
                                            <div class="col-md-6">
                                                {{ $data->event_from_date ? date('d-m-Y', strtotime($data->event_from_date)) : '' }}
                                                 to {{ $data->event_to_date ? date('d-m-Y', strtotime($data->event_to_date)) : '' }}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Seating</label>
                                            </div>
                                            <div class="col-md-6">
                                               {{ $data->seating_type_name }}

                                               </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Number Of Tickets</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control" max="???" min="???" id="no-of-tickets" name="no_of_tickets" required   value="{{ $data ? $data->no_of_tickets : '' }}" readonly>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Booking expiry Date & time</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="datetime-local" required class="form-control" name="booking_expiry_date_time"  value="{{ $data ? $data->booking_expiry_date_time : '' }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Disclaimer Notes</label>
                                            </div>
                                            <div class="col-md-6">

                                                 <textarea class="form-control" id="summernote" >
                                                    {{ $data ? $data->disclaimer_note : '' }}
                                                 </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Cancellation Policy Notes</label>
                                            </div>
                                            <div class="col-md-6">

                                                 <textarea class="form-control" id="" name="cancellation_policy_notes">
                                                    {{ $data ? $data->cancellation_policy_notes : '' }}
                                                 </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Status</label>
                                            </div>
                                            <div class="col-md-6">

                                                {!! Form::radio('is_active',true,1) !!} Active
                                                {!! Form::radio('is_active',false,0) !!} Inactive

                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="form-group mb-0">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Cover Image</label>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-controls-stacked">
                                                    <img src="{{ config('app.storage') ."uploads/ticket_images/". $data->cover_image }}"  alt="img" width="100px">

                                                    {{-- <img alt="" src="{{ Storage::disk('image')->url('uploads/ticket_images/' . $data->cover_image) }}"> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group mb-0">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label"> Image</label>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-controls-stacked">
                                                    <img src="{{ config('app.storage') ."uploads/ticket_images/". $data->image }}"  alt="img" width="100px">

                                                    {{-- <img alt="" src="{{ Storage::disk('image')->url('uploads/ticket_images/' . $data->image) }}"> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group mb-0">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label"> Map Layout</label>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-controls-stacked">
                                                    <img src="{{ config('app.storage') ."uploads/ticket_images/". $data->map_layout }}"  alt="img" width="100px">

                                                    {{-- <img alt="" src="{{ Storage::disk('image')->url('uploads/ticket_images/' . $data->map_layout) }}"> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label"> ID Proof</label>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-controls-stacked">
                                                  @if($data->proof_of_id)
                                                      <a href="{{ asset('storage/uploads/ticket_proof/proof_of_id/' . $data->proof_of_id) }}" target="_blank">
                                                          <img width="100" src="{{ asset('storage/uploads/ticket_proof/proof_of_id/' . $data->proof_of_id) }}" onerror="this.src='{{ asset('assets/img/default-document.jpg') }}'">
                                                      </a>
                                                  @else
                                                      <span class="text-muted">No document</span>
                                                  @endif  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label"> Proof of Purchase</label>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-controls-stacked">
                                                 @if($data->proof_of_purchase)
                                                     <a href="{{ asset('storage/uploads/ticket_proof/proof_of_purchase/' . $data->proof_of_purchase) }}" target="_blank">
                                                         <img width="100" src="{{ asset('storage/uploads/ticket_proof/proof_of_purchase/' . $data->proof_of_purchase) }}" onerror="this.src='{{ asset('assets/img/default-document.jpg') }}'">
                                                     </a>
                                                 @else
                                                     <span class="text-muted">No document</span>
                                                 @endif </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">

                                      <button type="button" onclick="window.history.back()" class="btn btn-primary waves-effect waves-light" style="float:right;">Back</button>
                                    </div>
                                    <br>


							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
