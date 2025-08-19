@extends('layouts.app')
@section('content')
        <!-- Basic Layout -->
        <div class="row mb-6 gy-6">

            <div class="col-xl">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add User Document</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('add_user_document') }}" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="row">


                                <div class="col-sm-4">
                                    <div class="mb-6">
                                        <label for="document_type" class="form-label">Document Type<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="document_type" name="document_type"
                                            aria-label="Select Type" required>
                                            <option value="">Select Type</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}" @selected(old('document_type') == $type->id)>
                                                    {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('document_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-6">
                                        <label for="user" class="form-label">User<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="user" name="user"
                                            aria-label="Select User" required>
                                            <option value="">Select User</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @selected(old('user') == $user->id)>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="mb-6">
                                        <label class="form-label" for="name">Document Name <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <span id="name2" class="input-group-text"><i
                                                    class="icon-base ti tabler-file"></i></span>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Document Name" aria-label="Document Name" required value="{{ old('name') }}"
                                                aria-describedby="name2" />
                                        </div>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="mb-6">
                                        <label for="file_upload" class="form-label">File<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="file" id="file_upload" name="file_upload" />
                                    </div>
                                    @error('file_upload')
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
