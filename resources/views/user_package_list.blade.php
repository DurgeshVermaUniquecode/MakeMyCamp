@extends('layouts.app')
@section('title', 'User List')
@section('content')
    <div class="card">
        <div class="pb-4 rounded-top">
            <div class="container py-12 px-xl-10 px-4">
                <h3 class="text-center mb-2 mt-4">Pricing Plans</h3>
                <p class="text-center mb-0">
                    Choose the best plan to fit your needs.
                </p>


                <div class="row mx-2 mt-3 px-lg-12 gy-6">

                    @if (!$userPackage)
                        @foreach ($packages as $package)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-md-0">
                                <div class="card border rounded shadow-none">
                                    <div class="card-body pt-12 px-5">
                                        <div class="mt-3 mb-5 text-center">
                                            <img src="{{ asset('categories_images/' . $package->image) }}"
                                                alt="Package Image" height="120" />
                                        </div>
                                        <h4 class="card-title text-center text-capitalize mb-1">{{ $package->name }}</h4>
                                        <p class="text-center mb-5">A simple start for everyone</p>
                                        <div class="text-center h-px-50">
                                            <div class="d-flex justify-content-center">
                                                <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">
                                                    <h4 class="mb-0 text-primary">{{ config('app.currency_symbol') }}
                                                        {{ $package->package->amount }}</h4>
                                                </sup>

                                            </div>
                                        </div>

                                        <p class="ps-6 my-5 pt-9">
                                            {{ $package->description }}
                                        </p>

                                        @if ($package->isActive)
                                            <a href="javascript:void(0);" class="btn btn-label-success d-grid w-100">Your
                                                Current Package</a>
                                        @else
                                            <button id="rzp-button" data-amount="{{ $package->package->amount * 100 }}"
                                                data-business_category="{{ $package->id }}"
                                                data-package_id="{{ $package->package->id }}"
                                                class="btn btn-label-primary d-grid w-100">Buy Now</button>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-md-0">
                            <div class="card border rounded shadow-none">
                                <div class="card-body pt-12 px-5">
                                    <div class="mt-3 mb-5 text-center">
                                        <img src="{{ asset('categories_images/' . $userPackage->business_category->image) }}" alt="Package Image"
                                            height="120" />
                                    </div>
                                    <h4 class="card-title text-center text-capitalize mb-1">{{ $userPackage->business_category->name }}</h4>
                                    <p class="text-center mb-5">A simple start for everyone</p>
                                    <div class="text-center h-px-50">
                                        <div class="d-flex justify-content-center">
                                            <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">
                                                <h4 class="mb-0 text-primary">{{ config('app.currency_symbol') }}
                                                    {{ $userPackage->business_category->package->amount }}</h4>
                                            </sup>

                                        </div>
                                    </div>

                                    <p class="ps-6 my-5 pt-9">
                                        {{ $userPackage->business_category->description }}
                                    </p>


                                        <a href="javascript:void(0);" class="btn btn-label-success d-grid w-100">Your
                                            Current Package</a>


                                </div>
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.getElementById('rzp-button').onclick = function(e) {
            e.preventDefault();

            const amount = this.dataset.amount;
            const business_id = this.dataset.business_category;
            const package_id = this.dataset.package_id;

            var options = {
                "key": "{{ config('services.razorpay.key') }}", // Enter the Key ID
                "amount": amount, // Amount in paise
                "currency": "INR",
                "name": "IgnitingBusiness",
                "description": "Payment For Package",
                "image": "",
                "order_id": "{{ $order_id ?? '' }}", // Pass the order_id created from backend
                "handler": function(response) {
                    // After successful payment
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('buy_package') }}';

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const fields = ['razorpay_payment_id', 'razorpay_order_id', 'razorpay_signature'];
                    fields.forEach(field => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = field;
                        input.value = response[field];
                        form.appendChild(input);
                    });

                    const customFields = {
                        business_id: business_id,
                        package_id: package_id
                    };

                    Object.keys(customFields).forEach(key => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = customFields[key];
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                },
                "prefill": {
                    "name": '{{ Auth::user()->name }}',
                    "email": '{{ Auth::user()->email }}'
                },
                "theme": {
                    "color": "#F37254"
                }
            };


            var rzp1 = new Razorpay(options);
            rzp1.open();
        }
    </script>
@endpush
