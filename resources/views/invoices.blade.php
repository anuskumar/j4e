<?php $page="invoices";?>
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
									<li class="breadcrumb-item active" aria-current="page">Invoices</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Invoices</h2>
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
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
											<img src="assets/img/speakers/speaker-thumb-02.jpg" alt="User Image">
										</a>
										<div class="profile-det-info">
											<h3>Wayte Barlow</h3>
											
											<div class="customer-details">
												<h5 class="mb-0">MCA, BE - 10+ Years Experience</h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li>
												<a href="speaker-dashboard">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="events">
													<i class="fas fa-calendar-check"></i>
													<span>Events</span>
												</a>
											</li>
											<li>
												<a href="my-customers">
													<i class="fas fa-user-injured"></i>
													<span>My Customers</span>
												</a>
											</li>
											<li>
												<a href="schedule-timings">
													<i class="fas fa-hourglass-start"></i>
													<span>Schedule Timings</span>
												</a>
											</li>
											<li class="active">
												<a href="invoices">
													<i class="fas fa-file-invoice"></i>
													<span>Invoices</span>
												</a>
											</li>
											<li>
												<a href="reviews">
													<i class="fas fa-star"></i>
													<span>Reviews</span>
												</a>
											</li>
											<li>
												<a href="chat-speaker">
													<i class="fas fa-comments"></i>
													<span>Message</span>
													<small class="unread-msg">23</small>
												</a>
											</li>
											<li>
												<a href="speaker-profile-settings">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li>
												<a href="social-media">
													<i class="fas fa-share-alt"></i>
													<span>Social Media</span>
												</a>
											</li>
											<li>
												<a href="speaker-change-password">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
											<li>
												<a href="index">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>
							</div>
							<!-- /Profile Sidebar -->
							
						</div>
						<div class="col-md-8 col-lg-8 col-xl-9">
							<div class="card card-table">
								<div class="card-body">
								
									<!-- Invoice Table -->
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Invoice No</th>
													<th>Customer</th>
													<th>Amount</th>
													<th>Paid On</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<a href="invoice-view">#INV-0010</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="customer-profile" class="avatar avatar-sm mr-2">
																<img class="avatar-img rounded-circle" src="assets/img/customers/customer.jpg" alt="User Image">
															</a>
															<a href="customer-profile">Thyme Frierson <span>#PT0016</span></a>
														</h2>
													</td>
													<td>$450</td>
													<td>14 Nov 2020</td>
													<td class="text-right">
														<div class="table-action">
															<a href="invoice-view" class="btn btn-sm bg-info-light">
																<i class="far fa-eye"></i> View
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																<i class="fas fa-print"></i> Print
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a href="invoice-view">#INV-0009</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="customer-profile" class="avatar avatar-sm mr-2">
																<img class="avatar-img rounded-circle" src="assets/img/customers/customer1.jpg" alt="User Image">
															</a>
															<a href="customer-profile">Cedrica Large <span>#PT0001</span></a>
														</h2>
													</td>
													<td>$200</td>
													<td>13 Nov 2020</td>
													<td class="text-right">
														<div class="table-action">
															<a href="invoice-view" class="btn btn-sm bg-info-light">
																<i class="far fa-eye"></i> View
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																<i class="fas fa-print"></i> Print
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a href="invoice-view">#INV-0008</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="customer-profile" class="avatar avatar-sm mr-2">
																<img class="avatar-img rounded-circle" src="assets/img/customers/customer2.jpg" alt="User Image">
															</a>
															<a href="customer-profile">Warford Cowan <span>#PT0002</span></a>
														</h2>
													</td>
													<td>$100</td>
													<td>12 Nov 2020</td>
													<td class="text-right">
														<div class="table-action">
															<a href="invoice-view" class="btn btn-sm bg-info-light">
																<i class="far fa-eye"></i> View
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																<i class="fas fa-print"></i> Print
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a href="invoice-view">#INV-0007</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="customer-profile" class="avatar avatar-sm mr-2">
																<img class="avatar-img rounded-circle" src="assets/img/customers/customer3.jpg" alt="User Image">
															</a>
															<a href="customer-profile">Axe Gibson <span>#PT0003</span></a>
														</h2>
													</td>
													<td>$350</td>
													<td>11 Nov 2020</td>
													<td class="text-right">
														<div class="table-action">
															<a href="invoice-view" class="btn btn-sm bg-info-light">
																<i class="far fa-eye"></i> View
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																<i class="fas fa-print"></i> Print
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a href="invoice-view">#INV-0006</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="customer-profile" class="avatar avatar-sm mr-2">
																<img class="avatar-img rounded-circle" src="assets/img/customers/customer4.jpg" alt="User Image">
															</a>
															<a href="customer-profile">Mia Lerner <span>#PT0004</span></a>
														</h2>
													</td>
													<td>$275</td>
													<td>10 Nov 2020</td>
													<td class="text-right">
														<div class="table-action">
															<a href="invoice-view" class="btn btn-sm bg-info-light">
																<i class="far fa-eye"></i> View
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																<i class="fas fa-print"></i> Print
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a href="invoice-view">#INV-0005</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="customer-profile" class="avatar avatar-sm mr-2">
																<img class="avatar-img rounded-circle" src="assets/img/customers/customer5.jpg" alt="User Image">
															</a>
															<a href="customer-profile">Secorra Dowling <span>#PT0005</span></a>
														</h2>
													</td>
													<td>$600</td>
													<td>9 Nov 2020</td>
													<td class="text-right">
														<div class="table-action">
															<a href="invoice-view" class="btn btn-sm bg-info-light">
																<i class="far fa-eye"></i> View
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																<i class="fas fa-print"></i> Print
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a href="invoice-view">#INV-0004</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="customer-profile" class="avatar avatar-sm mr-2">
																<img class="avatar-img rounded-circle" src="assets/img/customers/customer6.jpg" alt="User Image">
															</a>
															<a href="customer-profile">Ellie Kent <span>#PT0006</span></a>
														</h2>
													</td>
													<td>$50</td>
													<td>8 Nov 2020</td>
													<td class="text-right">
														<div class="table-action">
															<a href="invoice-view" class="btn btn-sm bg-info-light">
																<i class="far fa-eye"></i> View
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																<i class="fas fa-print"></i> Print
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a href="invoice-view">#INV-0003</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="customer-profile" class="avatar avatar-sm mr-2">
																<img class="avatar-img rounded-circle" src="assets/img/customers/customer7.jpg" alt="User Image">
															</a>
															<a href="customer-profile">Branice Grier <span>#PT0007</span></a>
														</h2>
													</td>
													<td>$400</td>
													<td>7 Nov 2020</td>
													<td class="text-right">
														<div class="table-action">
															<a href="invoice-view" class="btn btn-sm bg-info-light">
																<i class="far fa-eye"></i> View
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																<i class="fas fa-print"></i> Print
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a href="invoice-view">#INV-0002</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="customer-profile" class="avatar avatar-sm mr-2">
																<img class="avatar-img rounded-circle" src="assets/img/customers/customer8.jpg" alt="User Image">
															</a>
															<a href="customer-profile">Augy Naranjo <span>#PT0008</span></a>
														</h2>
													</td>
													<td>$550</td>
													<td>6 Nov 2020</td>
													<td class="text-right">
														<div class="table-action">
															<a href="invoice-view" class="btn btn-sm bg-info-light">
																<i class="far fa-eye"></i> View
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																<i class="fas fa-print"></i> Print
															</a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a href="invoice-view">#INV-0001</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="customer-profile" class="avatar avatar-sm mr-2">
																<img class="avatar-img rounded-circle" src="assets/img/customers/customer9.jpg" alt="User Image">
															</a>
															<a href="customer-profile">Speero Dobbs <span>#PT0009</span></a>
														</h2>
													</td>
													<td>$100</td>
													<td>5 Nov 2020</td>
													<td class="text-right">
														<div class="table-action">
															<a href="invoice-view" class="btn btn-sm bg-info-light">
																<i class="far fa-eye"></i> View
															</a>
															<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																<i class="fas fa-print"></i> Print
															</a>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- /Invoice Table -->
									
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
			</div>
	   @endsection
	  