@extends('layouts.app')
@section('content')
    <div class="row mb-6 gy-6">

        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Blog</h5>
                </div>
                <div class="card-body">
                    <form id="addBlog" action="{{ route('blog_store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row"> 

                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label for="category" class="form-label">Category<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2" id="category" name="category"
                                        aria-label="Select Category" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category') == $category->id)>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label for="image" class="form-label">Image<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="file" id="image" name="image" />
                                </div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                                    <select class="selectpicker w-100" data-style="btn-default" id="status" name="status" data-placeholder="Select Status" required>
                                        <option value="Pending" @selected(old('status') == 'Pending')>Pending</option>
                                        <option value="Schedule" @selected(old('status') == 'Schedule')>Schedule</option>
                                        <option value="Publish" @selected(old('status') == 'Publish')>Publish</option>
                                        <option value="Unpublish" @selected(old('status') == 'Unpublish')>Unpublish</option>
                                    </select>
                                    @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-sm-3" id="div_schedule_date"  @if (old('status') == 'Schedule') @else style="display: none;" @endif>
                                <div class="mb-6">
                                    <label for="schedule_date" class="form-label">Schedule Date<span class="text-danger">*</span></label>
                                    <input class="form-control" type="datetime-local" id="schedule_date" name="schedule_date" value="{{ old('schedule_date', now()) }}" />
                                </div>
                                @error('schedule_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-12">
                                <div class="mb-6">
                                    <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="title2" class="input-group-text"><i class="icon-base ti tabler-package"></i></span>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="First Course" aria-label="First Course" value="{{ old('title') }}" aria-describedby="title2" />
                                    </div>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
   
                            <textarea name="content" id="content" style="display: none;"></textarea>

                            <div class="col-sm-12">
                                <div class="mb-6">
                                    <label class="form-label" for="content">Content<span class="text-danger">*</span></label>
                                    <div id="full-editor"> {!! old('content') !!} </div>
                                    @error('content')
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
@push('scripts')
    <script>
        
        $('#status').on('change', function (e) {
            $('#div_schedule_date').hide();
            if($('#status').val() == 'Schedule') {
                $('#div_schedule_date').show();
            }
        });

        var fullEditor = new Quill('#full-editor', {
            bounds: '#full-editor',
            placeholder: 'Type Something...',
            modules: {
                syntax: true,
                toolbar: fullToolbar
            },
            theme: 'snow'
        });

        $('#addBlog').on('submit', function () {
            const html = fullEditor.root.innerHTML;
            $('#content').val(html);
        });
    </script>
@endpush

