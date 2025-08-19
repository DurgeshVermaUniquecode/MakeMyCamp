@extends('layouts.app')
@section('content')
<div class="row mb-6 gy-6">
    <div class="col-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Update {{ $data->sc_name }} Content</h5>
            </div>
            <div class="card-body">
                <form id="addContent" action="{{ route('static_content', [ $data->sc_type]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-sm-12 mb-6">
                                <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span id="title2" class="input-group-text"><i class="icon-base ti tabler-package"></i></span>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" aria-label="Enter Title" value="{{ $data->sc_title }}" />
                                </div>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>

                        <textarea name="description" id="description" style="display: none;"></textarea>

                        <div class="col-sm-12">
                            <div class="mb-6">
                                <label class="form-label" for="description">Description<span class="text-danger">*</span></label>
                                <div id="full-editor"> {!! $data->sc_desc !!} </div>
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
@push('scripts')
    <script>
        var fullEditor = new Quill('#full-editor', {
            bounds: '#full-editor',
            placeholder: 'Type Something...',
            modules: {
                syntax: true,
                toolbar: fullToolbar
            },
            theme: 'snow'
        });

        $('#addContent').on('submit', function () {
            const html = fullEditor.root.innerHTML;
            $('#description').val(html);
        });
    </script>
@endpush