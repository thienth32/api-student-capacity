<script>
    var hostUrl = "assets/";
</script>
<script src="https://kit.fontawesome.com/29b41ee1c8.js" crossorigin="anonymous"></script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
{{-- <script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script> --}}
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
{{-- <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script> --}}
<!-- JavaScript Bundle with Popper -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js">
</script>

{{-- Set up plugin global --}}
<script src="assets/js/system/configplugins/configplugins.js"></script>

{{-- Chat js --}}
<script>
    $('.sp-show-1').show();
    setTimeout(function () {
        $('.sp-show-1').hide();
    },2000);
    $('.click-send-data').on('click',function () {
        var youChat = `
                <div class="d-flex justify-content-end mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column align-items-end">
                                <!--begin::User-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Details-->
                                    <div class="me-3">
                                        <span class="text-muted fs-7 mb-1">Now</span>
                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
                                    </div>
                                    <!--end::Details-->
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-1.jpg" />
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::User-->
                                <!--begin::Text-->
                                <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end"
                                     data-kt-element="message-text"
                                >${$(this).data('mess')}</div>
                                <!--end::Text-->
                            </div>

                            <!--end::Wrapper-->
                        </div>
        `;
        $('.chat-hide').show();
        $('.show-chat-d').append(youChat);
        if($(this).data('key') == 1)
        {
            $('.chat-hide').attr('style','display:none !important');
            $('.show-chat-d').append(
                `
                        <div class="d-flex justify-content-start mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column align-items-start">
                                <!--begin::User-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-25.jpg" />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Details-->
                                    <div class="ms-3">
                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Admin</a>
                                        <span class="text-muted fs-7 mb-1">Now</span>
                                    </div>
                                    <!--end::Details-->
                                </div>
                                <!--end::User-->
                                <!--begin::Text-->
                                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" d
                                    ata-kt-element="message-text">
                                    Bạn thuộc quyền {{ auth()->user()->roles[0]->name }}
                                    </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                `
            );
        }else
        {
            $.ajax({
                url: `api/public/support-capacity?support_id=`+$(this).data('key'),
                method: "GET",
                success: function (data) {
                    $('.chat-hide').attr('style','display:none !important');
                    if(data.payload.arr)
                    {
                        var adminChat = data.payload.data.map(function (data) {
                            return `
                                <li>Cuộc thi ${data.name}</li>

                            `;
                        }).join(" ");
                    }else{
                        var adminChat = data.payload;
                    }
                    $('.show-chat-d').append(
                        `
                        <div class="d-flex justify-content-start mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column align-items-start">
                                <!--begin::User-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-25.jpg" />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Details-->
                                    <div class="ms-3">
                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Admin</a>
                                        <span class="text-muted fs-7 mb-1">Now</span>
                                    </div>
                                    <!--end::Details-->
                                </div>
                                <!--end::User-->
                                <!--begin::Text-->
                                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">${adminChat}</div>
                                <!--end::Text-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                `
                    );
                },
                error: function (jqXHR, exception) {
                    $('.chat-hide').attr('style','display:none !important');

                    $('.show-chat-d').append(
                        `
                        <div class="d-flex justify-content-start mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column align-items-start">
                                <!--begin::User-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic" src="assets/media/avatars/300-25.jpg" />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Details-->
                                    <div class="ms-3">
                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Admin</a>
                                        <span class="text-muted fs-7 mb-1">Now</span>
                                    </div>
                                    <!--end::Details-->
                                </div>
                                <!--end::User-->
                                <!--begin::Text-->
                                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">Chưa thể trả lời chính xác câu hỏi của bạn !</div>
                                <!--end::Text-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                `
                    );
                }
            });
        }
    });
</script>
