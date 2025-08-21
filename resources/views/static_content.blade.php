@extends('layouts.app_front')
@section('content')
<div class="breadcumb-area d-flex">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12 text-center">
				<div class="breadcumb-content">
					<div class="breadcumb-title">
						<h4>{{ $data->sc_title }}</h4>
					</div>
					<ul>
						<li><a href="{{ route('home') }}"><i class="bi bi-house-door-fill"></i> Home </a></li>
						<li class="rotates"><i class="bi bi-slash-lg"></i>{{ $data->sc_title }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="about_area style_two">
	<div class="container">
		{!! $data->sc_desc !!}
	</div>
</section>
@endsection