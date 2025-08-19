@extends('layouts.app')
@section('content')
    <!-- Basic Layout -->
    <div class="row mb-6 gy-6">

        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Update Configuration</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('update_config') }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach ($data as $value)
                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label class="form-label" for="{{ $value->name }}">{{ $value->title }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="{{ $value->name }}" name="{{ $value->name }}" placeholder="Enter {{ $value->title }}" aria-label="Enter {{ $value->title }}" value="{{ $value->value }}" aria-describedby="name2" />
                                    @error($value->name)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @endforeach
                        </div>


                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
