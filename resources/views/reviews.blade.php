<?php $page="reviews";?>
@extends('layout.mainlayout')
@section('content')
<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Reviews</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Reviews</h2>
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
							<div class="doc-review review-listing">

								<!-- Review Listing -->
								<ul class="comments-list">
									@forelse ($customer_reviews as $review)
									<li>
										<div class="comment">
											<img class="avatar rounded-circle" alt="{{ $review->customer_name }}"
												src="{{ $review->photoUrl() }}"
												onerror="this.src='{{ asset('assets/img/testimonial/avatar-01.jpg') }}'">
											<div class="comment-body">
												<div class="meta-data">
													<span class="comment-author">{{ $review->customer_name }}</span>
													@if ($review->subtitle)
													<span class="comment-date">{{ $review->subtitle }}</span>
													@endif
													<div class="review-count rating">
														@include('partials.star_rating', ['rating' => $review->rating, 'showAverage' => true])
													</div>
												</div>
												<p class="comment-content">
													{{ $review->review_content }}
												</p>
											</div>
										</div>
									</li>
									@empty
									<li>
										<div class="comment">
											<div class="comment-body">
												<p class="comment-content mb-0">No customer reviews available yet.</p>
											</div>
										</div>
									</li>
									@endforelse
								</ul>
								<!-- /Comment List -->

							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- /Page Content -->
			</div>
	   @endsection
