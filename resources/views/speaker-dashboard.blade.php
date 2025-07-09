<?php $page="speaker-dashboard";?>
@extends('layout.mainlayout')
@section('content')
<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Dashboard</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar">

							<!-- Profile Sidebar -->
                            @include('layout.re_sidebar');

							<!-- /Profile Sidebar -->

						</div>

						<div class="col-md-8 col-lg-8 col-xl-9">

							<div class="row">
								<div class="col-md-12">
									<div class="card dash-card">
										<div class="card-body">
											<div class="row">
												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-wrap">
															<div class="circle-bar">
																<img src="assets/img/icon-01.png" class="img-fluid" alt="customer">
															</div>
														</div>
														<div class="dash-widget-info">
															<h6>Total Customer</h6>
															<h3>1500</h3>
														</div>
													</div>
												</div>

												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-wrap">
															<div class="circle-bar">
																<img src="assets/img/icon-02.png" class="img-fluid" alt="customer">
															</div>
														</div>
														<div class="dash-widget-info">
															<h6>Today Customer</h6>
															<h3>160</h3>
														</div>
													</div>
												</div>

												<div class="col-md-12 col-lg-4">
													<div class="dash-widget">
														<div class="circle-wrap">
															<div class="circle-bar">
																<img src="assets/img/icon-03.png" class="img-fluid" alt="customer">
															</div>
														</div>
														<div class="dash-widget-info">
															<h6>Events</h6>
															<h3>85</h3>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h4 class="mb-4">Customer Events</h4>
									<div class="appointment-tab">

										<!-- Appointment Tab -->
										<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
											<li class="nav-item">
												<a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">Upcoming</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#today-appointments" data-toggle="tab">Today</a>
											</li>
										</ul>
										<!-- /Appointment Tab -->

										<div class="tab-content">

											<!-- Upcoming Appointment Tab -->
											<div class="tab-pane show active" id="upcoming-appointments">
												<div class="card card-table mb-0">
													<div class="card-body">
														<div class="table-responsive">
															<table class="table table-hover table-center mb-0">
																<thead>
																	<tr>
																		<th>Customer Name</th>
																		<th>Event Date</th>
																		<th>Purpose</th>
																		<th>Type</th>
																		<th class="text-center">Paid Amount</th>
																		<th></th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer.jpg" alt="User Image"></a>
																				<a href="customer-profile">Thyme Frierson <span>#PT0016</span></a>
																			</h2>
																		</td>
																		<td>11 Nov 2020 <span class="d-block text-info">10.00 AM</span></td>
																		<td>Enquiry</td>
																		<td>New customer</td>
																		<td class="text-center">$150</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer1.jpg" alt="User Image"></a>
																				<a href="customer-profile">Cedrica Large <span>#PT0001</span></a>
																			</h2>
																		</td>
																		<td>3 Nov 2020 <span class="d-block text-info">11.00 AM</span></td>
																		<td>Enquiry</td>
																		<td>Old customer</td>
																		<td class="text-center">$200</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer2.jpg" alt="User Image"></a>
																				<a href="customer-profile">Warford Cowan  <span>#PT0002</span></a>
																			</h2>
																		</td>
																		<td>1 Nov 2020 <span class="d-block text-info">1.00 PM</span></td>
																		<td>Enquiry</td>
																		<td>New customer</td>
																		<td class="text-center">$75</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer3.jpg" alt="User Image"></a>
																				<a href="customer-profile">Axe Gibson <span>#PT0003</span></a>
																			</h2>
																		</td>
																		<td>30 Oct 2020 <span class="d-block text-info">9.00 AM</span></td>
																		<td>Enquiry</td>
																		<td>Old customer</td>
																		<td class="text-center">$100</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer4.jpg" alt="User Image"></a>
																				<a href="customer-profile">Mia Lerner <span>#PT0004</span></a>
																			</h2>
																		</td>
																		<td>28 Oct 2020 <span class="d-block text-info">6.00 PM</span></td>
																		<td>Enquiry</td>
																		<td>New customer</td>
																		<td class="text-center">$350</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer5.jpg" alt="User Image"></a>
																				<a href="customer-profile">Secorra Dowling <span>#PT0005</span></a>
																			</h2>
																		</td>
																		<td>27 Oct 2020 <span class="d-block text-info">8.00 AM</span></td>
																		<td>Enquiry</td>
																		<td>Old customer</td>
																		<td class="text-center">$250</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
											<!-- /Upcoming Appointment Tab -->

											<!-- Today Appointment Tab -->
											<div class="tab-pane" id="today-appointments">
												<div class="card card-table mb-0">
													<div class="card-body">
														<div class="table-responsive">
															<table class="table table-hover table-center mb-0">
																<thead>
																	<tr>
																		<th>Customer Name</th>
																		<th>Event Date</th>
																		<th>Purpose</th>
																		<th>Type</th>
																		<th class="text-center">Paid Amount</th>
																		<th></th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer6.jpg" alt="User Image"></a>
																				<a href="customer-profile">Ellie Kent <span>#PT0006</span></a>
																			</h2>
																		</td>
																		<td>14 Nov 2020 <span class="d-block text-info">6.00 PM</span></td>
																		<td>Booking</td>
																		<td>Old customer</td>
																		<td class="text-center">$300</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer7.jpg" alt="User Image"></a>
																				<a href="customer-profile">Branice Grier <span>#PT0006</span></a>
																			</h2>
																		</td>
																		<td>14 Nov 2020 <span class="d-block text-info">5.00 PM</span></td>
																		<td>Enquiry</td>
																		<td>Old customer</td>
																		<td class="text-center">$100</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer8.jpg" alt="User Image"></a>
																				<a href="customer-profile">Augy Naranjo <span>#PT0007</span></a>
																			</h2>
																		</td>
																		<td>14 Nov 2020 <span class="d-block text-info">3.00 PM</span></td>
																		<td>Enquiry</td>
																		<td>New customer</td>
																		<td class="text-center">$75</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer9.jpg" alt="User Image"></a>
																				<a href="customer-profile">Speero Dobbs <span>#PT0008</span></a>
																			</h2>
																		</td>
																		<td>14 Nov 2020 <span class="d-block text-info">1.00 PM</span></td>
																		<td>Enquiry</td>
																		<td>Old customer</td>
																		<td class="text-center">$350</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer10.jpg" alt="User Image"></a>
																				<a href="customer-profile">Paulus Peebles <span>#PT0010</span></a>
																			</h2>
																		</td>
																		<td>14 Nov 2020 <span class="d-block text-info">10.00 AM</span></td>
																		<td>Enquiry</td>
																		<td>New customer</td>
																		<td class="text-center">$175</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="customer-profile" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/customers/customer11.jpg" alt="User Image"></a>
																				<a href="customer-profile">Arvon Pappas <span>#PT0011</span></a>
																			</h2>
																		</td>
																		<td>14 Nov 2020 <span class="d-block text-info">11.00 AM</span></td>
																		<td>Enquiry</td>
																		<td>New customer</td>
																		<td class="text-center">$450</td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>

																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
											<!-- /Today Appointment Tab -->

										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>

			</div>
			<!-- /Page Content -->

			</div>
	   @endsection
