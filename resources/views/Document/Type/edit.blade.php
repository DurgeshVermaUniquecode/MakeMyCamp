@extends('layouts.app')
@section('content')
    <!-- Basic Layout -->
    <div class="row mb-6 gy-6">

        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Document Type</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('edit_document_type',[$type->id]) }}" method="POST">

                        @csrf
                        <div class="row">


                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label for="business_category" class="form-label">Business Category<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="business_category" name="business_category"
                                        aria-label="Business Category" required>
                                        <option value="">Business Category</option>
                                        @foreach ($businessCategories as $category)
                                            <option value="{{ $category->id }}" @selected(old('business_category',$type->business_category_id) == $category->id)>
                                                {{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('business_category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label class="form-label" for="name">Name <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="name2" class="input-group-text"><i
                                                class="icon-base ti tabler-user"></i></span>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Name" aria-label="Name" required value="{{ old('name',$type->name) }}"
                                            aria-describedby="name2" />
                                    </div>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>




                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label for="document_type" class="form-label">Type<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="document_type" name="document_type"
                                        aria-label="Select Type" required>
                                        <option value="">Select Type</option>
                                        <option value="image" @selected(old('document_type',$type->type) == 'image')>Image</option>
                                        <option value="pdf" @selected(old('document_type',$type->type) == 'pdf')>Pdf</option>
                                    </select>
                                    @error('document_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
