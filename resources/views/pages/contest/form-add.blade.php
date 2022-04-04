@extends('layouts.main')
@section('title', 'Thêm vòng thi')
@section('page-title', 'Thêm mới cuộc thi')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Done-circle.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                    <path
                                        d="M16.7689447,7.81768175 C17.1457787,7.41393107 17.7785676,7.39211077 18.1823183,7.76894473 C18.5860689,8.1457787 18.6078892,8.77856757 18.2310553,9.18231825 L11.2310553,16.6823183 C10.8654446,17.0740439 10.2560456,17.107974 9.84920863,16.7592566 L6.34920863,13.7592566 C5.92988278,13.3998345 5.88132125,12.7685345 6.2407434,12.3492086 C6.60016555,11.9298828 7.23146553,11.8813212 7.65079137,12.2407434 L10.4229928,14.616916 L16.7689447,7.81768175 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <strong></strong> {{ session()->get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    @php
                        Session::forget('success');
                    @endphp
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="svg-icon svg-icon-danger svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Warning-2.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M11.1669899,4.49941818 L2.82535718,19.5143571 C2.557144,19.9971408 2.7310878,20.6059441 3.21387153,20.8741573 C3.36242953,20.9566895 3.52957021,21 3.69951446,21 L21.2169432,21 C21.7692279,21 22.2169432,20.5522847 22.2169432,20 C22.2169432,19.8159952 22.1661743,19.6355579 22.070225,19.47855 L12.894429,4.4636111 C12.6064401,3.99235656 11.9909517,3.84379039 11.5196972,4.13177928 C11.3723594,4.22181902 11.2508468,4.34847583 11.1669899,4.49941818 Z"
                                        fill="#000000" opacity="0.3" />
                                    <rect fill="#000000" x="11" y="9" width="2" height="7" rx="1" />
                                    <rect fill="#000000" x="11" y="17" width="2" height="2" rx="1" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <strong></strong> {{ session()->get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    @php
                        Session::forget('error');
                    @endphp
                @endif
                <form id="formAddContest" action="{{ route('admin.contest.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-10">
                        <label for="">Tên cuộc thi</label>
                        <input type="text" name="name" value="{{ old('name') }}" class=" form-control" placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">


                        <div class="row">
                            <div class="col-8">

                                <div class="form-group mb-10">
                                    <label for="">Thời gian bắt đầu</label>
                                    <input value="{{ old('date_start') }}" type="datetime-local" max="" name="date_start"
                                        class="form-control" placeholder="">
                                    @error('date_start')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">
                                    <label for="">Thời gian kết thúc</label>
                                    <input value="{{ old('register_deadline') }}" min="" type="datetime-local"
                                        name="register_deadline" id="" class="form-control" placeholder="">
                                    @error('register_deadline')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-10 ms-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-3">
                                        <span>Ảnh cuộc thi</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Allowed file types: png, jpg, jpeg."
                                            aria-label="Allowed file types: png, jpg, jpeg."></i>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Image input wrapper-->
                                    <div class="mt-1">
                                        <!--begin::Image input-->
                                        <div style="position: relative" class="image-input image-input-outline"
                                            data-kt-image-input="true"
                                            style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-100px h-100px"
                                                style="background-image: url('assets/media/svg/avatars/blank.svg')"></div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Edit-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input value="{{ old('img') }}" type="file" name="img"
                                                    accept=".png, .jpg, .jpeg">
                                                {{-- <input type="hidden" name="avatar_remove"> --}}
                                                <!--end::Inputs-->
                                                <style>
                                                    label#img-error {
                                                        position: absolute;
                                                        min-width: 150px;
                                                        top: 500%;
                                                        right: -100%;
                                                    }

                                                </style>
                                            </label>
                                            <!--end::Edit-->
                                            <!--begin::Cancel-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Cancel avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->
                                            <!--begin::Remove-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Remove avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->
                                    </div>
                                    <!--end::Image input wrapper-->
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group mb-10">

                            <label for="" class="form-label">Thuộc cuộc thi</label>
                            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                data-hide-search="false" tabindex="-1" aria-hidden="true" name="contest_id"
                                value="{{ old('contest_id') }}">
                                @foreach ($contests as $contest)
                                    <option value="{{ $contest->id }}"> {{ $contest->name }}</option>
                                @endforeach
                            </select>

                            @error('contest_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div> --}}
                        <div class="form-group mb-10">

                            <label for="" class="form-label">Thuộc chuyên ngành</label>
                            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                data-hide-search="false" tabindex="-1" aria-hidden="true" name="major_id"
                                value="{{ old('major_id') }}">

                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}"> {{ $major->name }}</option>
                                @endforeach
                            </select>
                            @error('major_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group mb-10">
                        <label for="">Mô tả cuộc thi</label>
                        <textarea class="form-control" name="description" id="" rows="3"></textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id="" class="btn btn-success btn-lg btn-block">Lưu </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('js_admin')

    <script>
        $("#formAddContest").validate({
            onkeyup: true,
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                img: {
                    required: true,
                },
                date_start: {
                    required: true,
                },
                register_deadline: {
                    required: true,
                },
                description: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Chưa nhập trường này !',
                    maxlength: 'Tối đa là 255 kí tự !'
                },
                img: {
                    required: 'Chưa nhập trường này !',
                },
                date_start: {
                    required: 'Chưa nhập trường này !',
                    date: true
                },
                register_deadline: {
                    required: 'Chưa nhập trường này !',
                    date: true
                },
                description: {
                    required: 'Chưa nhập trường này !',
                },
            },
        });
    </script>


@endsection
