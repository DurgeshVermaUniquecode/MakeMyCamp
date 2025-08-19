@foreach ($messages as $message)
    @php
        $file = '';
        if(!empty($message->file) && in_array($message->file_type, ['jpg','jpeg','png'])) {
            $file = '<div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="' . asset('support_replies/' . $message->file) . '" alt="user image" class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" style="width: 150px !important; height: auto !important;">
                    </div>';
        } else if(!empty($message->file) && in_array($message->file_type, ['pdf'])) {
            $file = '<div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <div class="d-flex align-items-center">
                            <i class="icon-base ti tabler-file-type-pdf icon-48px ms-2 me-2 my-2"></i>
                            <span class="me-2">' . $message->file . '</span>
                            <a href="' . asset('support_replies/' . $message->file) . '" class="btn btn-sm btn-outline-primary rounded-2" download>
                                <i class="icon-base ti tabler-download"></i>
                            </a>
                        </div>
                    </div>';
        } else if(!empty($message->file) && in_array($message->file_type, ['doc','docx'])) {
            $file = '<div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <div class="d-flex align-items-center">
                            <i class="icon-base ti tabler-file-type-pdf icon-48px ms-2 me-2 my-2"></i>
                            <span class="me-2">' . $message->file . '</span>
                            <a href="' . asset('support_replies/' . $message->file) . '" class="btn btn-sm btn-outline-primary rounded-2" download>
                                <i class="icon-base ti tabler-download"></i>
                            </a>
                        </div>
                    </div>';
        } 
    @endphp
    <li class="chat-message {{Auth::user()->id == $message->user_id? 'chat-message-right':''}}">
        <div class="d-flex overflow-hidden">
            <div class="chat-message-wrapper flex-grow-1">
                {!! $file !!}
                <div class="chat-message-text">
                    <p class="mb-0">{{$message->description}}</p>
                </div>
                <div class="text-end text-body-secondary mt-1">
                    <small>{{$message->created_at}}</small>
                </div>
            </div>
        </div>
    </li>
@endforeach
