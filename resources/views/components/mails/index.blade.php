@extends('layouts.main')
@section('title', 'Thông báo ')
@section('page-title', 'Thông báo ')
@section('content')

    <div class="card card-flush p-4">

        {{-- Breadcrumb --}}
        {!! $bred !!}

        <form id="formContest" action="{{ $link }}" method="post" enctype="multipart/form-data">
            @csrf

            <!--begin::Stepper-->
            <div class="stepper stepper-pills" id="kt_stepper_example_basic">
                <!--begin::Nav-->
                <div class="stepper-nav flex-center flex-wrap mb-10">
                    <!--begin::Step 1-->
                    <div class="stepper-item mx-2 my-4 current" data-kt-stepper-element="nav">
                        <!--begin::Line-->
                        <div class="stepper-line w-40px"></div>
                        <!--end::Line-->

                        <!--begin::Icon-->
                        <div class="stepper-icon w-40px h-40px">
                            <i class="stepper-check fas fa-check"></i>
                            <span class="stepper-number">1</span>
                        </div>
                        <!--end::Icon-->

                        <!--begin::Label-->
                        <div class="stepper-label">
                            <h3 class="stepper-title">
                                Chi tiết mail
                            </h3>

                            <div class="stepper-desc">
                                Chi tiết mail
                            </div>
                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Step 1-->


                    <!--begin::Step 4-->
                    <div class="stepper-item mx-2 my-4" data-kt-stepper-element="nav">
                        <!--begin::Line-->
                        <div class="stepper-line w-40px"></div>
                        <!--end::Line-->

                        <!--begin::Icon-->
                        <div class="stepper-icon w-40px h-40px">
                            <i class="stepper-check fas fa-check"></i>
                            <span class="stepper-number">2</span>
                        </div>
                        <!--begin::Icon-->

                        <!--begin::Label-->
                        <div class="stepper-label">
                            <h3 class="stepper-title">
                                Hoàn tất
                            </h3>

                            <div class="stepper-desc">
                                Hoàn tất
                            </div>
                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Step 4-->
                </div>
                <!--end::Nav-->

                <!--begin::Form-->
                <div class="form mx-auto" novalidate="novalidate" id="kt_stepper_example_basic_form">
                    <!--begin::Group-->
                    <div class="mb-5">
                        <!--begin::Step 1-->
                        <div class="flex-column current" data-kt-stepper-element="content">

                            <div class="form-group mb-10">
                                <label for="" class="form-label">Tiêu đề gửi mail </label>
                                <input value="{{ old('subject') }}" type="text" class="form-control" name="subject"
                                    placeholder="Tiêu đề gửi mail ">
                                @error('subject')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-10">
                                <label for="" class="form-label">Nội dung gửi mail </label>

                                <!--begin::Alert-->
                                <div class="alert alert-primary">

                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Title-->
                                        <h4 class="mb-1 text-dark">Note</h4>
                                        <!--end::Title-->
                                        <!--begin::Content-->
                                        <p>$name = Tên người nhận</p>
                                        <p>$email = Email người nhận</p>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Alert-->


                                <textarea name="content" id="kt_docs_tinymce_hidden"> {{ old('content') }}</textarea>
                                @error('content')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <!--begin::Step 1-->

                        <!--begin::Step 1-->
                        <div class="flex-column" data-kt-stepper-element="content">

                            <div class="form-group mb-10">
                                <label for="" class="form-label">Danh sách sinh viên nhận mail </label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true" name="users[]"
                                    multiple="multiple">
                                    <option></option>
                                    @foreach ($judges as $judge)
                                        <option value="{{ $judge->email }}">{{ $judge->name }}
                                            -- {{ $judge->email }} (Ban giám khảo )</option>
                                    @endforeach
                                    @foreach ($users as $user)
                                        <option selected value="{{ $user->email }}">{{ $user->name }}
                                            -- {{ $user->email }} (Sinh viên)</option>
                                    @endforeach
                                </select>
                                @error('users')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <!--begin::Step 1-->




                    </div>
                    <!--end::Group-->

                    <!--begin::Actions-->
                    <div class="d-flex flex-stack">
                        <!--begin::Wrapper-->
                        <div class="me-2">
                            <button type="button" class="btn btn-light btn-active-light-primary"
                                data-kt-stepper-action="previous">
                                Quay lại
                            </button>
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Wrapper-->
                        <div>
                            <button class="btn btn-primary" data-kt-stepper-action="submit">
                                <span class="indicator-label">
                                    Gửi mail
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>

                            <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                Tiếp tục
                            </button>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Form-->
            </div>
            <!--end::Stepper-->
        </form>

    </div>

@endsection
@section('page-script')
    <script src="assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
    <script src="assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="assets/js/system/config-mail/mail.js"></script>
    @if (\Session::has('success'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toastr-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.success("{{ \Session::get('success') }}");
        </script>
    @endif
@endsection
