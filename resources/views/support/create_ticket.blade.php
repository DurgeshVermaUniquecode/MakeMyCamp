@extends('layouts.app')
@section('content')
    <!-- Basic Layout -->
    <div class="row mb-6 gy-6">
        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Send Request</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('store_ticket') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label for="request_for" class="form-label">Request For<span class="text-danger">*</span></label>
                                    <select class="form-select" id="request_for" name="request_for" aria-label="Select Request For" required>
                                        <option value="">Select Request For</option>
                                        <option value="Transaction Related">Transaction Related</option>
                                        <option value="Account Related">Account Related</option>
                                        <option value="Document Related">Document Related</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    @error('request_for')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label class="form-label" for="subject">Subject <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="subject2" class="input-group-text"><i class="icon-base ti tabler-user"></i></span>
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject" aria-label="Enter subject" required value="{{ old('subject') }}" aria-describedby="subject2" />
                                    </div>
                                    @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label class="form-label" for="file">File <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file" name="file" aria-describedby="email2" />
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="mb-6">
                                    <label class="form-label" for="description">Description</label>
                                    <div class="input-group">
                                        <textarea id="description" name="description" class="form-control" placeholder="Description"
                                            aria-label="Description" aria-describedby="Description">{{ old('description') }}</textarea>
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
