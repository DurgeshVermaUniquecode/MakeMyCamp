@extends('layouts.app_front')
@section('content')
@php
    $blogImage = asset('blog/'.$blog->image);
@endphp
<!--==================================================-->
<!-- Start Consalt Breadcumb Area -->
<!--==================================================-->
<div class="breadcumb-area d-flex style_two" style="background: url('{{ $blogImage }}'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12 text-center">
				<div class="breadcumb-content style_two">
					<span class="category">{{$blog->category->name}}</span>
					<div class="breadcumb-title style_two style_three">
						<h4>{{ $blog->title }}</h4>
					</div>
					<div class="breadcumb_meta-blog">
						<p><span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d M, Y') }}</span> </p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--==================================================-->
<!-- End Consalt Breadcumb Area -->
<!--==================================================-->

<!--==================================================-->
<!-- Start Consalt Service Details Area -->
<!--==================================================-->
<section class="portfolio_details pb-0">
	<div class="container">
		<div class="port_main style_two">
			{!! $blog->content !!}
            {{-- <div class="row">
				<div class="col-lg-12">
					<div class="pagination_container style_two">
						<!-- pagination category -->
						<ul class="blog-category">
							<li><a href="#">Technology</a></li>
							<li><a href="#">BUSINESS</a></li>
							<li><a href="#">sOFTWARE</a></li>
						</ul>						
						<!-- pagination item -->
						<div class="pagination_item">
							<div class="call_social_icon">
								<ul>
									<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
									<li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
									<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
									<li><a class="top-social-icon-left" href="#"><i class="fab fa-twitter"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="pagination_container">
						<!-- pagination item -->
						<div class="pagination_item">
							<div class="pagination_btn">
								<a href="#"><img src="assets/images/inner-img/pagination_icon1.png" alt="">Previous Projects</a>
							</div>
						</div>
						<!-- pagination item -->
						<div class="pagination_item">
							<div class="pagination_btn style_right">
								<a href="#">Previous Projects <img src="assets/images/inner-img/pagination_icon2.png" alt=""></a>
							</div>
						</div>
					</div>
				</div>
			</div> --}}
			{{-- <div class="row">
				<div class="col-lg-12">
					<div class="blog-details-contents">
						<h3>2 Comments</h3>	
					</div>

					<div class="blog-details-comment">
						<div class="blog-details-comment-thumb">
							<img src="assets/images/inner-img/aouthor.png" alt="">
						</div>
						<div class="blog-details-comment-reply">							
							<a href="#">Reply</a>
						</div>	
						<div class="blog-details-comment-content">							
							<h2>Md. Abu Taleb Sorkar</h2>	
							<span>12 August, 2024</span>								
							<p>Media leadership skills before cross-media innovation forward morph flexible whereas process-centric models
								Efficiently transform customer directed alignments for front-end meta Dramatically harness</p>

							
						</div>									
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="comment-form">
						<div class="comment-title">
							<h3>Post a Comments</h3>
							<p>Your eamil address will not be published. So, don’t worry.</p>
							<span></span>
						</div>
						<form action="https://formspree.io/f/myyleorq" method="POST" id="dreamit-form">
							<div class="row">
								<div class="col-md-12">
									<textarea name="comment-message" class="mb-20" id="comment-msg-box" cols="30" rows="4" placeholder="Weite Comments"></textarea>
								</div>
								<div class="col-md-6"><input type="text" class="comment-box" name="comment-name" placeholder="Your Name"></div>
								<div class="col-md-6"><input type="email" class="comment-box" name="comment-email" placeholder="Email"></div>

								<div class="col-lg-12"><input type="text" class="comment-box" name="comment-website" placeholder="Your Website"></div>									
								<div class="col-lg-12">
									<input type="submit" value="SUBMIT COMMENTS" class="submit-comment">
								</div>
							</div>
						</form>
						<div id="status"></div>
					</div>
				</div>
			</div> --}}
		</div>
	</div>
</section>
<!--==================================================-->
<!-- End Consalt Service Details Area -->
<!--==================================================-->

<!--==================================================-->
<!-- Start Consalt Blog Area -->
<!--==================================================-->
<section class="blog_area inner_page two pt-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="section_title text-center">
					<h1>Related Blog Post</h1>
				</div>
			</div>		
		</div>
		<div class="row">
            @foreach ($data as $blog)
            <div class="col-lg-4 col-md-6">
                <div class="single-blog-box">
                    <div class="single-blog-thumb">
                        <img src="{{asset('blog/'.$blog->image)}}" alt="{{ $blog->title }}"> 						
                    </div>
                    <div class="blog-content">
                        <div class="meta-blog">
                            <p><span class="solution">{{ $blog->category->name }}</span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d M, Y') }}</p>
                        </div>
                        <div class="blog-title">
                            <h3><a href="{{ route('blog_details', [$blog->slug]) }}">{{ Str::limit($blog->title, 50, '...') }}</a></h3>
                        </div>
                        <div class="blog_btn">
                            <a href="{{ route('blog_details', [$blog->slug]) }}">Read More <i class="flaticon flaticon-right-arrow"></i></a>
                        </div>
                    </div>
                </div>
            </div>  
            @endforeach				
		</div>
	</div>
</section>
<!--==================================================-->
<!-- End Consalt Blog Area -->
<!--==================================================-->
@endsection
