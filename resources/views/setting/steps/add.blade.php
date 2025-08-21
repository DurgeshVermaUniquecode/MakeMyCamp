@extends('layouts.app')
@section('content')
    <!-- Basic Layout -->
    <div class="row mb-6 gy-6">

        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Steps</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('add_step') }}" method="POST">

                        @csrf
                        <div class="row">



                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label class="form-label" for="title">Title <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="title2" class="input-group-text"><i
                                                class="icon-base ti tabler-article"></i></span>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="Title" aria-label="Title" required value="{{ old('title') }}"
                                            aria-describedby="title2" />
                                    </div>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label class="form-label" for="icon">Icon <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="icon2" class="input-group-text"><i
                                                class="icon-base ti tabler-icons"></i></span>
                                        <input type="text" class="form-control" id="icon"
                                            name="icon" placeholder="Icon"
                                            aria-label="Icon" required value="{{ old('icon') }}"
                                            aria-describedby="icon2" />
                                    </div>
                                    @error('icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                             <div class="col-sm-4">
                                <div class="mb-6">
                                    <label class="form-label" for="order">Order <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="order2" class="input-group-text"><i
                                                class="order-base ti tabler-sort-ascending-shapes"></i></span>
                                        <input type="text" class="form-control" id="order"
                                            name="order" placeholder="Order"
                                            aria-label="Order" required value="{{ old('order') }}"
                                            aria-describedby="order2" />
                                    </div>
                                    @error('order')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                        </div>


                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
