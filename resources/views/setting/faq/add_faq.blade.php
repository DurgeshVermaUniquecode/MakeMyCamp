@extends('layouts.app')
@section('content')
<div class="row mb-6 gy-6">
    <div class="col-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add FAQ</h5>
            </div>
            <div class="card-body">
                <form id="addContent" action="{{ route('faq_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-sm-10 mb-6">
                                <label class="form-label" for="question">Title <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span id="title2" class="input-group-text"><i class="icon-base ti tabler-package"></i></span>
                                    <input type="text" class="form-control" id="question" name="question" placeholder="Enter question" aria-label="Enter question" value="{{ old('question') }}" />
                                </div>
                                @error('question')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>

                        <div class="col-sm-2 mb-6">
                                <label class="form-label" for="order_by">Order By <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span id="title2" class="input-group-text"><i class="icon-base ti tabler-sort-ascending-numbers"></i></span>
                                    <input type="number" class="form-control" id="order_by" name="order_by" placeholder="Enter order by" aria-label="Enter order by" value="{{ old('order_by') }}" />
                                </div>
                                @error('order_by')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                        <textarea name="answer" id="answer" style="display: none;"></textarea>

                        <div class="col-sm-12">
                            <div class="mb-6">
                                <label class="form-label" for="answer">Answer<span class="text-danger">*</span></label>
                                <div id="full-editor"> {!! old('answer') !!} </div>
                                @error('answer')
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
            $('#answer').val(html);
        });
    </script>
@endpush