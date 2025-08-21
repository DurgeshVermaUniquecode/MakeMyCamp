@foreach ($messages as $message)
    <li class="chat-message {{Auth::user()->id == $message->user_id? 'chat-message-right':''}}">
        <div class="d-flex overflow-hidden">
            <div class="chat-message-wrapper flex-grow-1">
                @if (!empty($message->file))  
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    <img src="{{ asset('follow_ups_doc/'.$message->file) }}" alt="user image" class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img">
                </div>
                @endif
                <div class="chat-message-text">
                    <p class="mb-0">{{$message->message}}</p>
                </div>
                <div class="text-end text-body-secondary mt-1">
                    <small>{{$message->created_at}}</small>
                </div>
            </div>
        </div>
    </li>
@endforeach