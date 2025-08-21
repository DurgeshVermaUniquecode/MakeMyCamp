@extends('layouts.app')
@section('content')
    <!-- Basic Layout -->
    <div class="row mb-6 gy-6">

        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Package</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('add_user_package') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="mb-6">
                                    <label for="business_category" class="form-label">Business Categories<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="business_category" name="business_category"
                                        aria-label="Select Business Category" required>
                                        <option value="">Select Business Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('business_category') == $category->id)>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('business_category')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-6">
                                    <label for="user" class="form-label">User<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="user" name="user" aria-label="Select user"
                                        required>
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('user') == $user->id)>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('user')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>


                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
