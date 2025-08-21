@extends('layouts.app')
@section('content')
<!-- Basic Layout -->
<div class="row mb-6 gy-6">
    <div class="col-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Update Image</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('image_update',[$data->id]) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-6">
                                <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" aria-label="Enter Name" value="{{ old('name',$data->name) }}" />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-6">
                                <label for="type" class="form-label">Type<span class="text-danger">*</span></label>
                                <select class="form-select" id="type" name="type" aria-label="Select Type" required onchange="changeType(this.value)">
                                    <option value="Home Slider" @selected(old('type', $data->type) == 'Home Slider')>Home Slider</option>
                                    <option value="Home Abaut Consalt" @selected(old('type', $data->type) == 'Home Abaut Consalt')>Home Abaut Consalt</option>
                                    <option value="Home Our Testimonials" @selected(old('type', $data->type) == 'Home Our Testimonials')>Home Our Testimonials</option>
                                    <option value="Header Banner" @selected(old('type', $data->type) == 'Header Banner')>Header Banner</option>
                                    <option value="Other" @selected(old('type', $data->type) == 'Other')>Other</option>
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-6">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" id="image" name="image" accept="image/*" />
                            </div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                       <div class="col-sm-12">
                            <div class="mb-6">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Enter description" aria-label="Enter description">{{ old('description', $data->desc) }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-6">
                                <img src="{{ asset('banner/'.$data->image) }}" width="300">
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
