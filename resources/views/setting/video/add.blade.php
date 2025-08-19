@extends('layouts.app')
@section('content')
<!-- Basic Layout -->
<div class="row mb-6 gy-6">
    <div class="col-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add Video</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('video_store') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-6">
                                <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" aria-label="Enter Title" value="{{ old('title') }}" />
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-6">
                                <label class="form-label" for="url">Url <span class="text-danger">*</span></label>
                                <input type="url" class="form-control" id="url" name="url" placeholder="Enter url" aria-label="Enter url" value="{{ old('url') }}" />
                                @error('url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="mb-6">
                                <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" placeholder="Enter description" aria-label="Enter description">{{ old('description') }}</textarea>
                                @error('description')
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
