@extends('layouts.app')
@section('content')
    <!-- Basic Layout -->
    <div class="row mb-6 gy-6">

        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Task</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('add_task') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="row">


                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label for="employee" class="form-label">Employee<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="employee" name="employee"
                                        aria-label="Select Employee" required>
                                        <option value="">Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{$employee->id}}" @selected(old('employee') == $employee->id)>{{$employee->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('employee')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label class="form-label" for="title">Title <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="title2" class="input-group-text"><i
                                                class="icon-base ti tabler-article"></i></span>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="Titile" aria-label="Titile" required value="{{ old('title') }}"
                                            aria-describedby="title2" />
                                    </div>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label class="form-label" for="due_date">Due Date<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="dob2" class="input-group-text"><i
                                                class="icon-base ti tabler-calendar"></i></span>
                                        <input class="form-control" type="date" value="{{ old('due_date') }}"
                                            id="flatpickr-date" name="due_date" required />
                                    </div>
                                    @error('due_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-sm-12">
                                <div class="mb-6">
                                    <label class="form-label" for="remark">Remark</label>
                                    <div class="input-group">
                                        <textarea id="remark" name="remark" class="form-control" placeholder="Remark"
                                            aria-label="Remark" aria-describedby="remark">{{ old('remark') }}</textarea>
                                    </div>
                                    @error('remark')
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
