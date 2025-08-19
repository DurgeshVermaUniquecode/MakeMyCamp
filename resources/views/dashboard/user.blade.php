@extends('layouts.app')
@section('content')
    <div class="card p-6 mb-6">
        <div class="row gy-6">

            @foreach ($steps as $step)
                <div class="col-md">
                    <div class="form-check custom-option custom-option-icon {{ $step->status == 'Completed' ? 'checked' : '' }} checked"
                        @if ($step->status != 'Completed') style="border-color: #82808b" @endif>
                        <label class="form-check-label custom-option-content" for="customRadioIcon1">
                            <span class="custom-option-body">
                                <i class="icon-base ti tabler-{{ $step->icon }}"></i>
                                <span class="custom-option-title mb-2"> {{ $step->step }} </span>
                            </span>
                            <input name="customDeliveryRadioIcon" class="form-check-input" type="checkbox" value=""
                                id="customRadioIcon1" {{ $step->status == 'Completed' ? 'checked' : '' }} disabled
                                style="opacity: unset;" />
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row mb-6 g-6">
        <div class="col-12 col-xl-4 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="bg-label-primary rounded-3 text-center mb-4 pt-6">
                        @if ($package != null)
                            <img class="img-fluid"
                                src="{{ asset('categories_images/' . $package->business_category->image) }}"
                                alt="Card package image" width="140">
                        @else
                            <img class="img-fluid" src="{{ asset('assets/img/illustrations/girl-with-laptop.png') }}"
                                alt="Card girl image" width="140">
                        @endif

                    </div>
                    <h5 class="mb-2">
                        @if ($package != null)
                            {{ $package->business_category->name }}
                        @else
                            No Package Found
                        @endif
                    </h5>
                    <p class="small">
                        @if ($package != null)
                            {!! $package->business_category->description !!}
                        @else
                            Buy Package to boost your business.
                        @endif
                    </p>

                    <div class="row mb-4 g-3">
                        @if ($package != null)
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                class="icon-base ti tabler-calendar-event icon-28px"></i></span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">{{ $package->business_category->created_at }}</h6>
                                        <small>Date</small>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    @if ($package == null)
                        <div class="col-12 text-center">
                            <a href="{{ route('user_packages_list') }}"
                                class="btn btn-primary w-100 d-grid waves-effect waves-light">Buy Now</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
