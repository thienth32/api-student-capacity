@extends('layouts.main')
@section('title', 'Quản lý ' . $contest_type_text)
@section('page-title', 'Quản lý ' . $contest_type_text)
@section('page-style')
    <link href="assets/plugins/custom/cropper/cropper.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        .btn {
            padding-left: .75rem;
            padding-right: .75rem;
        }

        label.btn {
            margin-bottom: 0;
        }

        .d-flex>.btn {
            flex: 1;
        }

        .carbonads {
            border-radius: .25rem;
            border: 1px solid #ccc;
            font-size: .875rem;
            overflow: hidden;
            padding: 1rem;
        }

        .carbon-wrap {
            overflow: hidden;
        }

        .carbon-img {
            clear: left;
            display: block;
            float: left;
        }

        .carbon-text,
        .carbon-poweredby {
            display: block;
            margin-left: 140px;
        }

        .carbon-text,
        .carbon-text:hover,
        .carbon-text:focus {
            color: #fff;
            text-decoration: none;
        }

        .carbon-poweredby,
        .carbon-poweredby:hover,
        .carbon-poweredby:focus {
            color: #ddd;
            text-decoration: none;
        }

        @media (min-width: 768px) {
            .carbonads {
                float: right;
                margin-bottom: -1rem;
                margin-top: -1rem;
                max-width: 360px;
            }
        }

        .footer {
            font-size: .875rem;
            overflow: hidden;
        }

        .heart {
            color: #ddd;
            display: block;
            height: 2rem;
            line-height: 2rem;
            margin-bottom: 0;
            margin-top: 1rem;
            position: relative;
            text-align: center;
            width: 100%;
        }

        .heart:hover {
            color: #ff4136;
        }

        .heart::before {
            border-top: 1px solid #eee;
            content: " ";
            display: block;
            height: 0;
            left: 0;
            position: absolute;
            right: 0;
            top: 50%;
        }

        .heart::after {
            background-color: #fff;
            content: "♥";
            padding-left: .5rem;
            padding-right: .5rem;
            position: relative;
            z-index: 1;
        }

        .img-container,
        .img-preview {
            background-color: #f7f7f7;
            text-align: center;
            width: 100%;
        }

        .img-container {
            margin-bottom: 1rem;
            max-height: 497px;
            min-height: 200px;
        }

        @media (min-width: 768px) {
            .img-container {
                min-height: 497px;
            }
        }

        .img-container>img {
            max-width: 100%;
        }

        .docs-preview {
            margin-right: -1rem;
        }

        .img-preview {
            float: left;
            margin-bottom: .5rem;
            margin-right: .5rem;
            overflow: hidden;
        }

        .img-preview>img {
            max-width: 100%;
        }

        .preview-lg {
            height: 9rem;
            width: 16rem;
        }

        .preview-md {
            height: 4.5rem;
            width: 8rem;
        }

        .preview-sm {
            height: 2.25rem;
            width: 4rem;
        }

        .preview-xs {
            height: 1.125rem;
            margin-right: 0;
            width: 2rem;
        }

        .docs-data>.input-group {
            margin-bottom: .5rem;
        }

        .docs-data .input-group-prepend .input-group-text {
            min-width: 4rem;
        }

        .docs-data .input-group-append .input-group-text {
            min-width: 3rem;
        }

        .docs-buttons>.btn,
        .docs-buttons>.btn-group,
        .docs-buttons>.form-control {
            margin-bottom: .5rem;
            margin-right: .25rem;
        }

        .docs-toggles>.btn,
        .docs-toggles>.btn-group,
        .docs-toggles>.dropdown {
            margin-bottom: .5rem;
        }

        .docs-tooltip {
            display: block;
            margin: -.5rem -.75rem;
            padding: .5rem .75rem;
        }

        .docs-tooltip>.icon {
            margin: 0 -.25rem;
            vertical-align: top;
        }

        .tooltip-inner {
            white-space: normal;
        }

        .btn-upload .tooltip-inner,
        .btn-toggle .tooltip-inner {
            white-space: nowrap;
        }

        .btn-toggle {
            padding: .5rem;
        }

        .btn-toggle>.docs-tooltip {
            margin: -.5rem;
            padding: .5rem;
        }

        @media (max-width: 400px) {
            .btn-group-crop {
                margin-right: -1rem !important;
            }

            .btn-group-crop>.btn {
                padding-left: .5rem;
                padding-right: .5rem;
            }

            .btn-group-crop .docs-tooltip {
                margin-left: -.5rem;
                margin-right: -.5rem;
                padding-left: .5rem;
                padding-right: .5rem;
            }
        }

        .docs-options .dropdown-menu {
            width: 100%;
        }

        .docs-options .dropdown-menu>li {
            font-size: .875rem;
            padding: .125rem 1rem;
        }

        .docs-options .dropdown-menu .form-check-label {
            display: block;
        }

        .docs-cropped .modal-body {
            text-align: center;
        }

        .docs-cropped .modal-body>img,
        .docs-cropped .modal-body>canvas {
            max-width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    @contest
                        <a href="{{ route('admin.contest.list') }}" class="pe-3">
                            Danh sách cuộc thi
                        </a>
                    @else
                        <a href="{{ route('admin.contest.list', ['type' => 1]) }}" class="pe-3">
                            Danh sách đánh giá năng lực
                        </a>
                    @endcontest
                </li>
                <li class="breadcrumb-item px-3 text-muted">Thêm mới {{ $contest_type_text }}</li>
            </ol>
        </div>
    </div>
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
                                    <rect fill="#000000" x="11" y="9" width="2" height="7"
                                        rx="1" />
                                    <rect fill="#000000" x="11" y="17" width="2" height="2"
                                        rx="1" />
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
                <form id="formContest" action="{{ route('admin.contest.store') . '?type=' . request('type') ?? 0 }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-10">
                        <label for="" class="form-label">Tên {{ $contest_type_text }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" class=" form-control"
                            placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div>
                                <input type="hidden" name="date_start"
                                    value="{{ \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->addDays(3)->format('Y/m/d h:i:s') }}">
                                <input type="hidden" name="register_deadline"
                                    value="{{ \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->addDays(5)->format('Y/m/d h:i:s') }}">

                            </div>
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Thời gian bắt đầu & thời gian kết thúc </label>
                                <input name="app1" class="form-control form-control-solid"
                                    placeholder="Pick date rage" id="app1" />
                                @error('date_start')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @error('register_deadline')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            @contest
                                <input type="hidden" name="start_register_time"
                                    value="{{ \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->addDays(3)->format('Y/m/d h:i:s') }}">
                                <input type="hidden" name="end_register_time"
                                    value="{{ \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->addDays(5)->format('Y/m/d h:i:s') }}">
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Thời gian bắt đầu đăng ký & thời gian kết
                                        thúc
                                        đăng ký </label>
                                    <input name="app2" class="form-control form-control-solid"
                                        placeholder="Pick date rage" id="app2" />
                                    @error('start_register_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    @error('end_register_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            @else
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Thuộc kỹ năng </label>
                                    <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                        data-hide-search="false" multiple tabindex="-1" aria-hidden="true" name="skill[]"
                                        value="{{ old('skill') }}">
                                        @foreach ($skills as $skill)
                                            <option value="{{ $skill->id }}"> {{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('skill')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endcontest
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
                            @contest
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Ảnh banner</label>
                                    <div>
                                        <label for="upload_image_banner">
                                            <img id="uploaded_image" src="{{ asset('images/No-Image-2.png') }}"
                                                class=" w-100 max-h-250px cursor-pointer" />
                                            <input id="upload_image_banner" type="file" class="image_banner"
                                                style="display:none" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff" />
                                        </label>
                                    </div>
                                    @component('components.modal-cropper-image', ['name' => 'image_banner'])
                                    @endcomponent
                                    @error('image_banner')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endcontest
                        </div>
                        {{-- <div class="col-8">
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Thời gian bắt đầu </label>
                                <input id="begin" value="{{ old('date_start') }}" type="datetime-local"
                                    name="date_start" class="form-control" placeholder="">

                                @error('date_start')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-10">
                                <label for="" class="form-label">Thời gian kết thúc</label>
                                <input value="{{ old('register_deadline') }}" type="datetime-local"
                                    name="register_deadline" id="end" class="form-control" placeholder="">
                                @error('register_deadline')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            @if (request('type') != config('util.TYPE_TEST'))
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Thời gian bắt đầu đăng ký</label>
                                    <input value="{{ old('start_register_time') }}" type="datetime-local"
                                        name="start_register_time" id="start_time" class="form-control" placeholder="">
                                    @error('start_register_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Thời gian kết thúc đăng ký</label>
                                    <input value="{{ old('end_register_time') }}" type="datetime-local"
                                        name="end_register_time" id="end_time" class="form-control" placeholder="">
                                    @error('end_register_time')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
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
                        </div> --}}
                        <div class="col-4">
                            @contest
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Giới hạn thành viên trong đội</label>
                                    <input name="max_user" type='number' class="form-control" />
                                    @error('max_user')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endcontest
                            <div class="form-group ">
                                <label for="" class="form-label">Ảnh {{ $contest_type_text }}</label>
                                <input name="img" type='file' id="file-input" accept=".png, .jpg, .jpeg"
                                    class="form-control" />
                                @error('img')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                    src="{{ asset('images/No-Image-1.png') }}" />
                            </div>
                            @error('img')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror

                        </div>
                    </div>
                    <label for="" class="form-label">Phần thưởng theo mức điểm</label>
                    <div class="row mb-5 pb-5">
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Top 1</label>
                                <input name="top1" type='number' class="form-control" />
                                @error('top1')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Top 2</label>
                                <input name="top2" type='number' class="form-control" />
                                @error('top2')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Top 3</label>
                                <input name="top3" type='number' class="form-control" />
                                @error('top3')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Còn lại</label>
                                <input name="leave" type='number' class="form-control" />
                                @error('leave')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="form-group mb-10">
                        <label for="" class="form-label">Mô tả {{ $contest_type_text }}</label>
                        <textarea class="form-control " name="description" id="kt_docs_ckeditor_classic" rows="3">
                            {{ old('description') }}
                        </textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label for="" class="form-label">Tin tức</label>
                        <textarea class="form-control " name="post_new" id="kt_docs_ckeditor_classic2" rows="3">
                            {{ old('post_new') }}
                        </textarea>
                        @error('post_new')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10 ">
                        <button type="submit" name="" id=""
                            class="btn btn-success btn-lg btn-block">Lưu </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
@section('page-script')
    <script src="assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
    <script src="assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script type="text/javascript" src="assets/js/custom/documentation/general/ckfinder.js"></script>
    <script src="assets/js/system/ckeditor/ckeditor.js"></script>
    <script src="assets/js/system/preview-file/previewImg.js"></script>
    <script src="assets/js/system/contest/form.js"></script>
    <script src="assets/js/system/contest/contest.js"></script>
    <script src="assets/js/system/cropper/cropper.js"></script>
    <script src="assets/js/system/cropper/index.js"></script>
    <script>
        cropperImage.cropperImage('input#upload_image_banner', '#formContest')
    </script>


    <script>
        contestPage.topScore(
            "input[name='top1']",
            "input[name='top2']",
            "input[name='top3']",
            "input[name='leave']"
        );
        rules.img = {
            required: true,
        };
        messages.img = {
            required: 'Chưa nhập trường này !',
        };
        preview.showFile('#file-input', '#image-preview');
    </script>
    <script src="assets/js/system/validate/validate.js"></script>

@endsection
