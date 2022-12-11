@extends('layouts.main')
@section('title', 'Support ')
@section('page-title', 'Support')
@section('content')
    <div class="d-flex flex-column flex-lg-row">
        <input type="hidden" value="{{ session()->get('token') }}" class="show-token">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
            <!--begin::Contacts-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header pt-7" id="kt_chat_contacts_header">
                    <!--begin::Form-->
                    <form class="w-100 position-relative" autocomplete="off">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span
                            class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                    rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="black"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <!--end::Icon-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-search form-control-solid px-15" name="search"
                            value="" placeholder="Tìm kiếm theo tên hoặc email">
                        <!--end::Input-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-5" id="kt_chat_contacts_body">
                    <!--begin::List-->
                    <div class="scroll-y me-n5 show-online pe-5 h-200px h-lg-auto" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header"
                        data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="5px"
                        style="max-height: 601px;">
                        <!--begin::User-->
                        Đang chạy ...

                        <!--end::Separator-->

                    </div>
                    <!--end::List-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Contacts-->
        </div>
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
            <!--begin::Messenger-->
            <div class="card" style="display: none" id="kt_chat_messenger">
                <!--begin::Card header-->
                <div class="card-header" id="kt_chat_messenger_header">
                    <!--begin::Title-->
                    <div class="card-title">
                        <!--begin::User-->
                        <div class="d-flex justify-content-center flex-column me-3">
                            <a class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1">Support
                                box </a>
                            <!--begin::Info-->
                            <div class="mb-0 lh-1">
                                <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                                <span class="fs-7 fw-bold text-muted u-name">{{ auth()->user()->name }}</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Card toolbar-->

                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body" id="kt_chat_messenger_body">
                    <!--begin::Messages-->
                    <div class="scroll-y chat__list  me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                        data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px"
                        style="max-height: 454px; transform: rotate(180deg);">


                    </div>
                    <!--end::Messages-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                    <!--begin::Input-->
                    <textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input"
                        placeholder="Nhập tin nhắn "></textarea>
                    <!--end::Input-->
                    <!--begin:Toolbar-->
                    <div class="d-flex flex-stack">
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center me-2">
                            <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="Đang phát triển">
                                <i class="bi bi-paperclip fs-3"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="Đang phát triển">
                                <i class="bi bi-upload fs-3"></i>
                            </button>
                        </div>
                        <!--end::Actions-->
                        <!--begin::Send-->
                        <button class="btn send-chat btn-primary" type="button" data-kt-element="send">Gửi </button>
                        <!--end::Send-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card footer-->
            </div>
            <div class="card" id="kt_chat_messenger2">
                <div class="card-header" id="kt_chat_messenger_header">
                    <!--begin::Title-->
                    <div class="card-title">
                        <!--begin::User-->
                        <div class="d-flex justify-content-center flex-column me-3">
                            <a class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1 ">Support box</a>
                            <!--begin::Info-->
                            <div class="mb-0 lh-1">
                                <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                                <span class="fs-7 fw-bold text-muted  u-name">{{ auth()->user()->name }}</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Card toolbar-->

                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body" id="kt_chat_messenger_body">
                    <!--begin::Messages-->
                    <div class="scroll-y chat__list  me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                        data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px"
                        style="max-height: 454px; ">
                        <h1>Chào mừng bạn đến với hệ thống quản lý và hỗ trợ sinh viên </h1>
                        <h2> Poly chúc bạn một ngày làm việc hiệu quả ❤️</h2>
                        <img style="width: 100%"
                            src="https://jobsgo.vn/blog/wp-content/uploads/2022/03/Support-la-gi-4.jpg" alt="">
                    </div>
                    <!--end::Messages-->
                </div>
            </div>
            <!--end::Messenger-->
        </div>
        <!--end::Content-->
    </div>

@endsection
@section('page-script')
    <script src="{{ request()->getScheme() }}://{{ request()->getHost() }}:6001/socket.io/socket.io.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var users = [];
        var authId = "{{ auth()->user()->id }}";
        var authFr = 0;
        var roomCode = '';
        var data_chat = [];

        function renderUser(dataDefault = null) {


            data_chat = data_chat.filter(function(data) {
                return data.user.ctv_st_p == false;
            })

            var dataMap = dataDefault ?? data_chat;
            var html = dataMap.map(function(data) {
                const check = data_chat.filter(function(da) {
                    return da.id == data.user.id + '-' + authId;
                });

                return `
                  <button data-id="${data.user.id}" style=" width: 100%;  background: none; border: none;" role="button"
                    class="d-flex show-chat  mb-1  flex-stack py-4">
                            <div class="d-flex align-items-center">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-45px symbol-circle">
                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">USER</span>
                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2"></div>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Details-->
                                <div class="ms-5">
                                    <a   class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">${data.user.name}   </a>
                                    <div class="fw-bold text-muted">${check.length > 0 ? check[0].data.length > 0 ? check[0].data[0].message : '' : ''}</div>
                                </div>
                                <!--end::Details-->
                                <div class="d-flex flex-column align-items-end ms-2">
                                    ${check.length > 0 ? check[0].data.length > 0 ? check[0].data[0].id != authId ? '<span class="badge badge-sm badge-circle badge-danger"></span>' : '' : '' : ''}

                                </div>
                            </div>
                    </button>
                    <div class="separator  separator-dashed d-none"></div>

                `;
            }).join(" ");

            if (dataMap.length == 0) html = 'Không có ai hỗ trợ !';
            $('.show-online').html(html);
        }

        function renderChat(data) {
            var html = data.map(function(data) {
                return `
                        <div style=" transform: rotate(180deg);" class="d-flex justify-content-${data.id != authId ? 'start' : 'end'} mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column align-items-${data.id != authId ? 'start' : 'end'}">
                                <!--begin::User-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Details-->

                                    <!--end::Details-->
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-1.jpg">
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::User-->
                                <!--begin::Text-->
                                <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end"
                                    data-kt-element="message-text">${data.message}</div>
                                <!--end::Text-->
                            </div>
                            <!--end::Wrapper-->
                        </div>


                `;
            }).join("");
            if (data.length == 0) html = `
                <h2 style="transform: rotate(180deg);">Hãy bắt đầu hỗ trợ !</h2>
            `;
            $('.chat__list').html(html);
        }

        function checkUser() {
            var result = data_chat.filter(function(data) {
                return data.id == roomCode;
            });
            return result[0];
        }

        function checkUserGetKey(id) {
            var key = null;
            data_chat.filter(function(data, k) {

                if (data.id == id) key = k;
            });
            return key;
        }

        $(document).on('click', '.show-chat', function() {
            // window.Echo.leaveChannel(`private-support.poly.${roomCode}`);
            $('#kt_chat_messenger').show();
            $('#kt_chat_messenger2').hide();
            authFr = $(this).data('id');
            roomCode = $(this).data('id') + '-' + authId;

            $('.u-name').html(checkUser().user.email);
            renderChat(checkUser().data);

        });

        function privateChannel(code = null) {
            window.Echo.private(`support.poly.${code ?? roomCode}`)
                .listen('ChatSupportEvent', (e) => {

                    var k = checkUserGetKey(e.data.room);
                    data_chat[k].data.unshift(e.data);
                    var dataFist = data_chat[0];
                    data_chat[0] = data_chat[k];
                    data_chat[k] = dataFist;
                    console.log(data_chat);

                    renderUser();
                    if (e.data.room != roomCode) return;
                    renderChat(checkUser().data);

                });
        }
        $(document).on('click', '.send-chat', function() {
            $(this).html('Đang gửi');
            var that = this;
            const value = $('textarea').val();
            const room = authFr + '-' + authId;

            $.ajax({
                type: "POST",
                url: "http://127.0.0.1:8000/api/public/fake-post",
                data: {
                    message: value,
                    room: room
                },
                success: function(response) {
                    $(that).html('Gửi');
                },
                error: function(res) {
                    $(that).html('Gửi');
                },
            });

            $('textarea').val('');

        });

        $('.form-search').on('input', function() {
            var searchValue = $(this).val();
            var result = data_chat.filter(function(data) {
                return (data.user.name.search(searchValue) != -1) || (data.user.email.search(searchValue) !=
                    -1);
            });
            renderUser(result);
        });

        window.Echo.join('support.poly')
            .here((users) => {
                this.users = users;
                // this.users = [{
                //     id: 5,
                //     name: "Nguyễn Văn Trọng  2",
                //     email: "trongnvph1394922322323232323@fpt.edu.vn"
                // }, {
                //     id: 4,
                //     name: "Nguyễn Văn Trọng ",
                //     email: "trongnvph13949@fpt.edu.vn"
                // }, ];


                this.users.map(function(user) {
                    privateChannel(user.id + "-" + authId);
                    data_chat.push({
                        id: user.id + "-" + authId,
                        data: [],
                        user: user
                    });
                });

                renderUser();

            })
            .joining((user) => {
                this.users.push(user);
                privateChannel(user.id + "-" + authId);
                renderUser();
            })
            .leaving((user) => {
                var us = this.users.filter(function(data) {
                    return data.id !== user.id;
                });
                window.Echo.leaveChannel(`private-support.poly.${user.id + "-" + authId}`);
                this.users = us;
                renderUser();
            });
    </script>
@endsection
