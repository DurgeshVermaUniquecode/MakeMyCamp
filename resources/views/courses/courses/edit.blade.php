@extends('layouts.app')
@section('content')
    <!-- Basic Layout -->
    <div class="row mb-6 gy-6">

        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Course</h5>
                </div>
                <div class="card-body">
                    <form id="editCourse" action="{{ route('edit_course', [$course->id]) }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf


                        <div class="row">


                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label for="category" class="form-label">Category<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="category" name="category" aria-label="Select Category"
                                        required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category', $course->id) == $category->id)>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
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
                                                class="icon-base ti tabler-package"></i></span>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="First Course" aria-label="First Course"
                                            value="{{ old('title', $course->title) }}" aria-describedby="title2" />
                                    </div>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label for="thumbnail" class="form-label">Thumbnail Image<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="file" id="thumbnail" name="thumbnail" />
                                </div>
                                @error('thumbnail')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-sm-4">
                                <div class="mb-6">
                                    <label for="file_type" class="form-label">File Type<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="file_type" name="file_type"
                                        aria-label="Select File Type" required onchange="changeFileType(this.value)">
                                        <option value="pdf" @selected(old('file_type', $course->file_type) == 'pdf')>PDF</option>
                                        <option value="pdf_url" @selected(old('file_type', $course->file_type) == 'pdf_url')>PDF URL</option>
                                        <option value="video" @selected(old('file_type', $course->file_type) == 'video')>Video</option>
                                        <option value="video_url" @selected(old('file_type', $course->file_type) == 'video_url')>Video URL</option>
                                    </select>
                                    @error('file_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4" id="path_file">
                                <div class="mb-6">
                                    <label for="file_upload" class="form-label">File<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="file" id="file_upload" name="file_upload" />
                                </div>
                                @error('file_upload')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-12" id="path_url" style="display: none;">
                                <div class="mb-6">
                                    <label class="form-label" for="path">Path<span class="text-danger">*</span>
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="path" name="path"
                                            placeholder="Padth to PDF or Video" aria-label="Padth to PDF or Video"
                                            value="{{ old('path', $course->path) }}" aria-describedby="path2" />
                                    </div>
                                    @error('path')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <textarea name="description" id="description" style="display: none;"></textarea>


                            <div class="col-sm-12">
                                <div class="mb-6">
                                    <label class="form-label" for="description">Description<span
                                            class="text-danger">*</span>
                                        <span class="text-danger">*</span></label>
                                    <div id="full-editor">
                                        {!! old('description', $course->description) !!}
                                    </div>
                                    @error('description')
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
@push('scripts')
    <script>
        function changeFileType(type) {
            if (type == 'pdf' || type == 'video') {
                $('#path_file').show();
                $('#path_url').hide();
            } else if (type == 'pdf_url' || type == 'video_url') {
                $('#path_file').hide();
                $('#path_url').show();
            }
        }

        var fullEditor = new Quill('#full-editor', {
            bounds: '#full-editor',
            placeholder: 'Type Something...',
            modules: {
                syntax: true,
                toolbar: fullToolbar
            },
            theme: 'snow'
        });

        $('#editCourse').on('submit', function() {
            const html = fullEditor.root.innerHTML;
            $('#description').val(html);
        });
    </script>
@endpush
