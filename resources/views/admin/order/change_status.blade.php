<?php $page="slide/update";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-6">


						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">update Status</div>
                                <form class="form-horizontal" action="{{ url('customer_order/order_status_change') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="purchase_id" value="{{ $data->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Status </label>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control" name="status_id" required>
                                                    <option value="">Select</option>
                                                    @foreach ($status as $sta )
                                                    <option value="{{ $sta->id }}">{{ $sta->status_name }}</option>
                                                    @endforeach

                                                </select>
                                                {{-- <img alt="" width="100" height="100" src="{{ Storage::disk('image')->url('uploads/slide/'. $data->slide_image) }}"> --}}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Remark</label>
                                            </div>
                                            <div class="col-md-6">
                                                {{-- <input type="textarea" class="form-control"  placeholder="About company" value="Web Designer"> --}}
                                                <textarea class="form-control"  name="remark"  >
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Document</label>
											</div>
											<div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="custom-controls-stacked">
                                                        <input type="file" class="form-control"  placeholder="banner" name="document">
                                                          </div>
                                                </div>

											</div>
										</div>
									</div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Update</button></a>
                                </div>
								</form>

						</div>
					</div>
                    <div class="col-lg-6">


						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label"> Status Log</div>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Remark</th>
                                        <th>File</th>
                                        <th>Added By</th>
                                        @if(Auth::user()->user_type == 'superadmin')
                                        <th>Del</th>
                                        @endif
                                    </tr>
                                    @foreach ($log as $lo)
                                    <tr>
                                        <td>{{ date('d m Y',strtotime($lo->created_at)) }}</td>
                                        <td>{{ $lo->status_name }}</td>
                                        <td>{{ $lo->remark }}</td>
                                        <td>
                                            @if($lo->document)
                                            @if($lo->document)
                                                <a href="{{ asset('storage/uploads/purchase_status_document/' . $lo->document) }}" target="_blank">See</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                            @endif
                                            <td>{{ $lo->name }}</td>
                                            @if(Auth::user()->user_type == 'superadmin')
                                            <td><a href="{{ url('customer_order/delete_status_log',$lo->id) }}" onclick="return confirm('Are you sure you want to delete this log ?');"> Delete</a></td>
                                            @endif
                                        </tr>
                                    @endforeach

                                </table>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
