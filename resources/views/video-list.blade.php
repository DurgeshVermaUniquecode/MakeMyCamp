@extends('layouts.app_front')
@section('content')
<div class="breadcumb-area d-flex">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12 text-center">
				<div class="breadcumb-content">
					<div class="breadcumb-title">
						<h4>Videos</h4>
					</div>
					<ul>
						<li><a href="{{ route('home') }}"><i class="bi bi-house-door-fill"></i> Home </a></li>
						<li class="rotates"><i class="bi bi-slash-lg"></i>Videos</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="about_area style_two pt-5">
    <div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="section_title text-center">
					<h4>LATEST WORKS</h4>
					<h1>Visit the Real Results of</h1>
					<h1> Latest Case Studies</h1>
				</div>
			</div>
		</div>
		<div class="row image_load" style="position: relative; height: 2308.85px;">
			@foreach ($data as $value)
			<div class="col-lg-6 col-md-6 grid-item physics" style="position: absolute; left: 0px; top: 0px;">
				<div class="portfolio_item">
					<div class="portfolio_thumb">
                        <iframe width="100%" height="400" class="rounded-4" src="{{ $value->url }}"></iframe>
						<div class="portfolio_content">
							<div class="prot-text">	
								<span>{{ $value->title }}</span>								
								<h3> <a href="javascript:void(0)"> {{ $value->description }}</a></h3>	
							</div>	
							<div class="port_right">
								<a href="javascript:void(0)"><i class="bi bi-arrow-right-short"></i></a>
							</div>						
						</div>
					</div>
				</div>
			</div>	
			@endforeach		
		</div>
	</div>
</section>
@endsection