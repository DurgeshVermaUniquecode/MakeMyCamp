@extends('layouts.app')
@section('content')
<!-- Basic Layout -->
<div class="row mb-6 gy-6">

    <div class="col-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Update Category</h5>
            </div>
            <div class="card-body">
                <form action="{{route('blog_categories_update',[$category->id])}}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="mb-6">
                                <label class="form-label" for="name">Name <span
                                        class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span id="name2" class="input-group-text"><i
                                            class="icon-base ti tabler-package"></i></span>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="First Package" aria-label="First Package"
                                        value="{{ old('name',$category->name) }}" aria-describedby="name2" />
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-6">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" id="image"
                                    name="image" accept="image/*" />
                            </div>
                            @error('image')
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
