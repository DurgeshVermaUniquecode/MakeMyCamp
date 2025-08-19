@extends('layouts.app')
@section('content')
<style>
  .message-container {
  position: relative;
}

.message-container .dropdown {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 9999;
}
</style>
      <div class="app-chat card overflow-hidden">
          <div class="row g-0">
              <!-- Chat & Contacts -->
                <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end" id="app-chat-contacts">
                    <div class="sidebar-header h-px-75 px-5 border-bottom d-flex align-items-center">
                      <div class="d-flex align-items-center me-6 me-lg-0">
                        <h5 class="text-primary mb-0">Ticket Info</h5>
                      </div>
                      <i class="icon-base ti tabler-x icon-lg cursor-pointer position-absolute top-50 end-0 translate-middle d-lg-none d-block" data-overlay data-bs-toggle="sidebar" data-target="#app-chat-contacts"></i>
                    </div>
                  <div class="sidebar-body">
                    <!-- Chats -->
                    <ul class="list-unstyled chat-contact-list py-2 mb-0" id="chat-list">
                      <li class="chat-contact-list-item chat-list-item-0" style="margin-block: unset;padding-block: unset;align-items: flex-start;">
                        <span class="h6 me-1">Request No. :</span>
                        <span>{{$data->code}}</span>
                      </li>

                      <li class="chat-contact-list-item chat-list-item-0" style="margin-block: unset;padding-block: unset;align-items: flex-start;">
                        <span class="h6 me-1">Request For :</span>
                        <span>{{$data->for}}</span>
                      </li>

                      <li class="chat-contact-list-item chat-list-item-0" style="margin-block: unset;padding-block: unset;align-items: flex-start;">
                        <span class="h6 me-1">Request Date :</span>
                        <span>{{$data->created_at}}</span>
                      </li>

                      <li class="chat-contact-list-item chat-list-item-0" style="margin-block: unset;padding-block: unset;align-items: flex-start;">
                        <span class="h6 me-1">User Name :</span>
                        <span>{{$data->user->name}}</span>
                      </li>

                      <li class="chat-contact-list-item chat-list-item-0" style="margin-block: unset;padding-block: unset;align-items: flex-start;">
                        <span class="h6 me-1">User Phone :</span>
                        <span>{{$data->user->phone_number}}</span>
                      </li>

                      <li class="chat-contact-list-item chat-list-item-0" style="margin-block: unset;padding-block: unset;align-items: flex-start;">
                        <span class="h6 me-1">Subject :</span>
                        <span>{{$data->subject}}</span>
                      </li>

                      <li class="chat-contact-list-item chat-list-item-0" style="margin-block: unset;padding-block: unset;align-items: flex-start;">
                        <span class="h6 me-1">Assigned To :</span>
                        <span>{{$data->user->name}}</span>
                      </li>

                      <li class="chat-contact-list-item chat-list-item-0" style="margin-block: unset;padding-block: unset;align-items: flex-start;">
                        <span class="h6 me-1">Assigned Date :</span>
                        <span>{{$data->assigned_date}}</span>
                      </li>

                      <li class="chat-contact-list-item chat-list-item-0" style="margin-block: unset;padding-block: unset;align-items: flex-start;">
                        <span class="h6 me-1">Status :</span>
                        <span class="badge bg-label-success">{{$data->status}}</span>
                      </li>

                    </ul>
                    <!-- Contacts -->

                  </div>
                </div>
                <!-- /Chat contacts -->

              <!-- Chat History -->
              <div class="col app-chat-history d-block" id="app-chat-history">
                  <div class="chat-history-wrapper">
                    <div class="chat-history-header border-bottom">
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex overflow-hidden align-items-center">
                          <i
                            class="icon-base ti tabler-menu-2 icon-lg cursor-pointer d-lg-none d-block me-4"
                            data-bs-toggle="sidebar"
                            data-overlay
                            data-target="#app-chat-contacts"></i>
                          <div class="flex-shrink-0 avatar avatar-online">                              
                            <img
                              src="{{ asset('images/user-1.svg') }}"
                              alt="Avatar"
                              class="rounded-circle"
                              data-bs-toggle="sidebar"
                              data-overlay
                              data-target="#app-chat-sidebar-right" />
                          </div>
                          <div class="chat-contact-info flex-grow-1 ms-4">
                            <h6 class="m-0 fw-normal">{{ $data->user_name }}</h6>
                            <small class="user-status text-body">{{ $data->company_name }}</small>
                          </div>
                        </div>
                        <div class="d-flex align-items-center">
                          <span
                            class="btn btn-text-secondary cursor-pointer d-sm-inline-flex d-none me-1 btn-icon rounded-pill">
                            <i class="icon-base ti tabler-arrow-left-dashed icon-22px"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                      <div class="chat-history-body" id="chat-container">
                          <ul class="list-unstyled chat-history" id="chat-history">
                            @include('support.partials.messages-list') 
                          </ul>
                      </div>

                      <!-- Chat message form -->
                      @if($data->status != 'Closed')
                      <div class="chat-history-footer shadow-xs" style="margin-top:  2.2rem;">
                          <form class="form-send-message" action="{{route('store_reply_ticket',[$data->id])}}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <div class=" d-flex justify-content-between align-items-center">
                                <input class="form-control message-input border-0 me-4 shadow-none" placeholder="Type your message here..." name="message" required/>
                                <div class="message-actions d-flex align-items-center">
                                    <label for="attach-doc" class="form-label mb-0">
                                      <span class="btn btn-text-secondary btn-icon rounded-pill cursor-pointer mx-1">
                                        <i class="icon-base ti tabler-paperclip icon-22px text-heading"></i>
                                      </span>
                                      <input type="file" id="attach-doc" name="attachment_doc" hidden />
                                    </label>
                                    <button class="btn btn-primary d-flex send-msg-btn" type="submit">
                                        <span class="align-middle d-md-inline-block d-none">Send</span>
                                        <i class="icon-base ti tabler-send icon-16px ms-md-2 ms-0"></i>
                                    </button>
                                </div>
                              </div>
                          </form>
                      </div>
                      @endif
                  </div>
              </div>
              <!-- /Chat History -->


          </div>
      </div>
@endsection
@push('scripts')
  <script src="{{ asset('assets/js/app-chat.js') }}"></script>

  <script>
    let loading = false;
    const chatContainer = document.getElementById('chat-container');
    const chatHistory = document.getElementById('chat-history');

    chatContainer.addEventListener('scroll', function () {
        if (chatContainer.scrollTop === 0 && !loading) {
            loading = true;

            const firstMessage = chatHistory.querySelector('li');
            const beforeId = firstMessage?.dataset?.id;

            const oldScrollHeight = chatContainer.scrollHeight;

            fetch(`/follow-up/{{ $data->id }}?before_id=${beforeId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => res.text())
                .then(data => {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data;
                    const newMessages = tempDiv.querySelectorAll('li');

                    newMessages.forEach(msg => {
                        chatHistory.insertBefore(msg, chatHistory.firstChild);
                    });

                    const newScrollHeight = chatContainer.scrollHeight;
                    chatContainer.scrollTop = newScrollHeight - oldScrollHeight;

                    loading = false;
                })
                .catch(() => loading = false);
        }
    });
  </script>

@endpush
