@extends('layouts.app')
@section('content')
<!-- Basic Layout -->
<div class="row mb-6 gy-6">
    <div class="col-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add Category</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('blog_categories_store') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-6">
                                <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span id="name2" class="input-group-text"><i class="icon-base ti tabler-package"></i></span>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="First Category" aria-label="First Category" value="{{ old('name') }}" aria-describedby="name2" />
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-6">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" id="image" name="image" accept="image/*" />
                            </div>
                            @error('image')
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
