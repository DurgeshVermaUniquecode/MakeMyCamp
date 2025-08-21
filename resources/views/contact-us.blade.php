
@extends('layouts.app_front')
@section('content')
<!--==================================================-->
<!-- Start Consalt Breadcumb Area -->
<!--==================================================-->
<div class="breadcumb-area d-flex">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12 text-center">
				<div class="breadcumb-content">
					<div class="breadcumb-title">
						<h4>Contact Us</h4>
					</div>
					<ul>
						<li><a href="index.html"><i class="bi bi-house-door-fill"></i> Home </a></li>
						<li class="rotates"><i class="bi bi-slash-lg"></i>Contact</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--==================================================-->
<!-- End Consalt Breadcumb Area -->
<!--==================================================-->

<!--==================================================-->
<!-- Start Consalt Contact Area Inner Page -->
<!--==================================================-->
<section class="contact_area inner_section">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="section_title">
					<h4>GET IN TOUCH</h4>
					<h1>Trusted By the Genius </h1>
					<h1>People with Consalt</h1>
					<p>Media leadership skills before cross-media innovation main technology
						develop standardized platforms without consalt.</p>
				</div>
				<div class="contact_main_info">
					<div class="call-do-action-info">
						<div class="call-do-social_icon">
							<i class="fas fa-phone-alt"></i>
						</div>
						<div class="call_info">
							<p>Call us Anytime</p>
							<h3>{{ config('app.contact_us') }}</h3>
						</div>
					</div>
					<div class="call-do-action-info">
						<div class="call-do-social_icon">
							<i class="fas fa-envelope-open"></i>
						</div>
						<div class="call_info">
							<p>Mail us Anytime</p>
							<h3>{{ config('app.email') }}</h3>
						</div>
					</div>
					<div class="call-do-action-info">
						<div class="call-do-social_icon">
							<i class="fas fa-map-marker-alt"></i>
						</div>
						<div class="call_info">
							<p>Our Locations</p>
							<span>{{ config('app.address') }}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<!-- contact form box -->
				<div class="contact-form-box style_two">
					<!-- section title -->
					<div class="section_title style_three style_four text-center ">
						<h4>CONTACT US</h4>
						<h1>Get In Touch with Consalt</h1>
					</div>
					@if(session('success'))
						<div class="alert alert-success mt-3">{{ session('success') }}</div>
					@endif
					<form action="{{ route('contact.submit') }}" method="POST">
						@csrf
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-box">
									<input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}">
									@error('name') <small class="text-danger">{{ $message }}</small> @enderror
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-box">
									<input type="text" name="phone" placeholder="Phone No" value="{{ old('phone') }}">
									@error('phone') <small class="text-danger">{{ $message }}</small> @enderror
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-box">
									<input type="email" name="email" placeholder="E-Mail Address" value="{{ old('email') }}">
									@error('email') <small class="text-danger">{{ $message }}</small> @enderror
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-box">
									<input type="text" name="subject" placeholder="Subject" value="{{ old('subject') }}">
									@error('subject') <small class="text-danger">{{ $message }}</small> @enderror
								</div>
							</div>
							<div class="col-lg-12 col-md-12">
								<div class="form-box message">
									<textarea name="message" cols="30" rows="5" placeholder="Write Message">{{ old('message') }}</textarea>
									@error('message') <small class="text-danger">{{ $message }}</small> @enderror
								</div>
							</div>
							<div class="checkbox mb-3">
								<label>
									<input type="checkbox" name="accept_terms" {{ old('accept_terms') ? 'checked' : '' }}> I agree to terms
								</label>
								@error('accept_terms') <br><small class="text-danger">{{ $message }}</small> @enderror
							</div>
							<div class="contact-form">
								<button type="submit"><i class="far fa-thumbs-up"></i> Request Call Back</button>
							</div>
						</div>
					</form>
					<div id="status"></div>
				</div> 
			</div>
		</div>

	</div>

	<div class="contact_shape2 dance2">
		<img src="assets/images/home_3/service_shpe2.png" alt="">
	</div>
</section>
<!--==================================================-->
<!-- End Consalt Contact Area  Inner Page -->
<!--==================================================-->



<!--==================================================-->
<!-- Start Consalt Map Area -->
<!--==================================================-->
<div class="map-section">
	<div class="-custon-container-fluid">
		<div class="row">
			<div class="col-lg-12 p-0">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d48384.367867189205!2d-74.01058227968896!3d40.71751035716885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1609671967457!5m2!1sen!2sbd" width="1920" height="520" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
			</div>
		</div>
	</div>
</div>
<!--==================================================-->
<!-- Start Consalt Map Area -->
<!--==================================================-->


<!--==================================================-->
<!-- Start Consalt Call Area -->
<!--==================================================-->
<section class="call_area style_three">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-4 col-md-6">
				<div class="call-do-action-info">
					<div class="call-do-social_icon">
						<i class="fas fa-phone-alt"></i>
					</div>
					<div class="call_info">
						<p>Say Hello</p>
						<h3>example@gmail.com</h3>
					</div>
				</div>		
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="footer_logo">
					<a href="index.html"><img src="assets/images/logo.png" alt=""></a>
				</div>
			</div>

			<div class="col-lg-4 col-md-6">
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

	</div>
</section>
<!--==================================================-->
<!-- End Consalt Call Area -->
<!--==================================================-->
@endsection