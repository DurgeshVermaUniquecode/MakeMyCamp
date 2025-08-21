@extends('layouts.app')
@section('content')
<!-- Basic Layout -->
<div class="row mb-6 gy-6">
    <div class="col-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add Business Category</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('add_business_category') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="mb-6">
                                <label for="package" class="form-label">Package<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="package" name="package"
                                    aria-label="Select Package" required>
                                    <option value="">Select Package</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" @selected(old('package_id') == $package->id)>
                                            {{ $package->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('package_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-3">
                            <div class="mb-6">
                                <label for="document_type" class="form-label">Document Type<span
                                        class="text-danger">*</span></label>
                                <select class="selectpicker w-100" id="document_type" name="document_type[]"
                                    data-style="btn-default" multiple data-icon-base="icon-base ti"
                                    data-tick-icon="tabler-check text-white" required>
                                    @foreach ($documents as $document)
                                        <option value="{{ $document->id }}" @selected(in_array($document->id,old('document_type')))>
                                            {{ $document->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('document_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>




                        <div class="col-sm-3">
                            <div class="mb-6">
                                <label class="form-label" for="name">Name <span
                                        class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span id="name2" class="input-group-text"><i
                                            class="icon-base ti tabler-package"></i></span>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="First Category" aria-label="First Category"
                                        value="{{ old('name') }}" aria-describedby="name2" />
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>



                        <div class="col-sm-3">
                            <div class="mb-6">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" id="image" name="image"
                                    accept="image/*" />
                            </div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>




                        <div class="col-sm-12">
                            <div class="mb-6">
                                <label class="form-label" for="description">Description<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <textarea id="description" name="description" class="form-control" placeholder="Description" aria-label="Description"
                                        aria-describedby="Description">{{ old('description') }}</textarea>
                                </div>
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
