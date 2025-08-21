@extends('layouts.app')
@section('title', 'User List')
@section('content')
    <div class="row mb-6">

        @foreach ($userDocuments as $document)
            <div class="col-xl-3 col-lg-3 col-sm-4 mb-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="mb-4 text-heading icon-base ti tabler-{{ $document->document_type->type == 'pdf' ? 'file-type-pdf' : 'photo-scan' }} icon-32px"></i>
                        <h5>{{ $document->document_type->name }}</h5>

                            <p>Document Name : {{ $document->name ?? '-' }}</p>
                            @if($document->status == 'Not Approved')
                            <button type="button" class="btn btn-primary" onclick="openUploadModal('{{$document->id}}')">
                                Upload
                            </button>
                            @endif

                            @if($document->path != null)
                            <a href="{{ asset('user_documents/' . $document->path) }}" download
                                class="btn btn-primary">Show</a>
                                @endif

                    </div>
                </div>
            </div>
        @endforeach


    </div>




    <div class="modal fade" id="documentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-simple modal-pricing">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    <div class="rounded-top">
                        <form action="{{ route('user_documents_list') }}" method="post" enctype="multipart/form-data">
                            <div class="row gy-4">
                                @csrf
                                <input type="hidden" name="document_id" id="document_id" value="{{ old('document_id') }}">
                                <div class="col-sm-12">
                                    <div class="mb-6">
                                        <label class="form-label" for="name">Document Name <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <span id="name2" class="input-group-text"><i
                                                    class="icon-base ti tabler-file"></i></span>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Document Name" aria-label="Document Name" required
                                                value="{{ old('name') }}" aria-describedby="name2" />
                                        </div>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <div class="mb-6">
                                        <label for="file_upload" class="form-label">File<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="file" id="file_upload" name="file_upload" />
                                    </div>
                                    @error('file_upload')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary" >
                                    Upload
                                </button>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--/ Content -->


@endsection

@push('scripts')

<script>
    function openUploadModal(id){
        $('#document_id').val(id);
        $('#documentModal').modal('show');
    }
</script>


@if($errors->any())
    <script>
        $('#documentModal').modal('show');
    </script>
@endif

@endpush
