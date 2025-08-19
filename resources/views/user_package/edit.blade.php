@extends('layouts.app')
@section('content')
    <!-- Basic Layout -->
    <div class="row mb-6 gy-6">

        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Update User Package</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('edit_user_package', [$userPackage->id]) }}" method="POST">

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
                                            <option value="{{ $category->id }}" @selected(old('business_category',$userPackage->business_category_id) == $category->id)>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('business_category')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>




                        </div>


                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
