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
            height: 10rem;
            width: 17rem;
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
                <li class="breadcrumb-item px-3 text-muted">Cập nhập {{ $contest_type_text . ' ' . $contest->name }} </li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12">
            <div class="card card-flush h-lg-100 p-10">
                <form id="formContest"
                    action="{{ route('admin.contest.update', ['id' => $contest->id]) . '?type=' . request('type') ?? 0 }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Tên {{ $contest_type_text }}</label>
                        <input type="text" name="name" value="{{ old('name', $contest->name) }}" class=" form-control"
                            placeholder="">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">

                        <div class="row">
                            <div class="col-8">
                                <div>
                                    <input type="hidden" name="date_start" value="{{ $contest->date_start }}">
                                    <input type="hidden" name="register_deadline"
                                        value="{{ $contest->register_deadline }}">
                                </div>
                                @if ($contest->date_start > now())
                                    <div class="form-group mb-10">
                                        <label for="" class="form-label">Thời gian bắt đầu & thời gian kết thúc
                                        </label>

                                        <input name="app1" class="form-control form-control-solid"
                                            placeholder="Pick date rage" id="app1" />
                                        @error('date_start')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                        @error('register_deadline')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>
                                @else
                                    <!--begin::Alert-->
                                    <div class="alert alert-warning">
                                        <!--begin::Icon-->
                                        <span class="svg-icon svg-icon-2hx svg-icon-primary me-3"><i
                                                class="bi bi-bell-fill"></i></span>
                                        <!--end::Icon-->

                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column">
                                            <!--begin::Title-->
                                            <h4 class="mb-1 text-dark">{{ \Str::title($contest_type_text) }} đang diễn ra
                                                hoặc đã diễn
                                                ra </h4>
                                            <!--end::Title-->
                                            <!--begin::Content-->
                                            <span>Thời gian bắt đầu đã bắt đầu vào {{ $contest->date_start }} và sẽ không
                                                thể thay đổi !</span>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Alert-->

                                    <div class="form-group mb-10">
                                        <label for="" class="form-label">Thời gian kết thúc</label>
                                        <input type="text" value="{{ $contest->register_deadline }}"
                                            class="form-control form-control-solid" name="app0" />
                                        @error('register_deadline')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif

                                @contest
                                    <input type="hidden" name="start_register_time"
                                        value="{{ $contest->start_register_time }}">
                                    <input type="hidden" name="end_register_time" value="{{ $contest->end_register_time }}">
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
                                                <option @selected(in_array($skill->id, $skillContests)) value="{{ $skill->id }}">
                                                    {{ $skill->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('skill')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endcontest
                                <div class="form-group mb-10">
                                    <label for="" class="form-label">Thuộc Chuyên Ngành</label>
                                    <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                        data-placeholder="Select an option" tabindex="-1" aria-hidden="true"
                                        name="major_id">
                                        <option data-select2-id="select2-data-130-vofb"></option>
                                        @foreach ($major as $valueMajor)
                                            <option @selected($contest->major_id == $valueMajor->id) value="{{ $valueMajor->id }}">
                                                {{ $valueMajor->name }}</option>
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
                                                <img id="uploaded_image"
                                                    src="{{ old('image_banner', $contest->image_banner) ?? asset('images/No-Image-2.png') }}"
                                                    class=" w-100 max-h-250px" />
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
                                    <label class="form-label" for="">Thời gian bắt đầu</label>
                                    <input value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($contest->date_start)) }}"
                                        type="datetime-local" id="begin" max="" name="date_start"
                                        class="form-control" placeholder="">

                                    @error('date_start')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-10">
                                    <label class="form-label" for="">Thời gian kết thúc</label>
                                    <input
                                        value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($contest->register_deadline)) }}"
                                        min="" type="datetime-local" name="register_deadline" id="end"
                                        class="form-control" placeholder="">
                                    @error('register_deadline')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                @if (request('type') != config('util.TYPE_TEST'))
                                    <div class="form-group mb-10">
                                        <label for="" class="form-label">Thời gian bắt đầu đăng ký</label>
                                        <input max="" min=""
                                            value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($contest->start_register_time)) }}"
                                            type="datetime-local" name="start_register_time" id="start_time"
                                            class="form-control" placeholder="">
                                        @error('start_register_time')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-10">
                                        <label for="" class="form-label">Thời gian kết thúc đăng ký</label>
                                        <input min="" max=""
                                            value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($contest->end_register_time)) }}"
                                            type="datetime-local" name="end_register_time" id="end_time"
                                            class="form-control" placeholder="">
                                        @error('end_register_time')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif

                            </div> --}}
                            <div class="col-4">
                                @contest
                                    <div class="form-group mb-10">
                                        <label for="" class="form-label">Giới hạn thành viên trong đội</label>
                                        <input value="{{ old('max_user', $contest->max_user) }}" name="max_user"
                                            type='number' class="form-control" />
                                        @error('max_user')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endcontest
                                <div class="form-group ">
                                    <label for="" class="form-label">Ảnh {{ $contest_type_text }}</label>
                                    <input value="{{ old('img') }}" name="img" type='file' id="file-input"
                                        class="form-control" accept=".png, .jpg, .jpeg" />
                                    @error('img')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <img class="w-100 mt-4 border rounded-3" id="image-preview"
                                        src="{{ $contest->img ? $contest->img : asset('images/No-Image-1.png') }} " />

                                </div>
                            </div>

                        </div>

                    </div>
                    <label for="" class="form-label">Phần thưởng theo mức điểm</label>
                    <div class="row mb-5 pb-5">
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Top 1</label>
                                <input value="{{ old('top1', $rewardRankPoint->top1 ?? null) }}" name="top1"
                                    type='number' class="form-control" />
                                @error('top1')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Top 2</label>
                                <input value="{{ old('top2', $rewardRankPoint->top2 ?? null) }}" name="top2"
                                    type='number' class="form-control" />
                                @error('top2')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Top 3</label>
                                <input value="{{ old('top3', $rewardRankPoint->top3 ?? null) }}" name="top3"
                                    type='number' class="form-control" />
                                @error('top3')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group mt-4 ">
                                <label for="" class="form-label">Còn lại</label>
                                <input value="{{ old('leave', $rewardRankPoint->leave ?? null) }}" name="leave"
                                    type='number' class="form-control" />
                                @error('leave')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Mô tả {{ $contest_type_text }}</label>
                        <textarea class="form-control" name="description" id="kt_docs_ckeditor_classic" rows="3">
                            {{ $contest->description }}
                        </textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-10">
                        <label class="form-label" for="">Tin tức</label>
                        <textarea class="form-control" name="post_new" id="kt_docs_ckeditor_classic2" rows="3">
                            {{ $contest->post_new }}
                        </textarea>
                        @error('post_new')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- <div class="form-group mb-10">
                        <label class="form-label" for="">Trạng thái {{ $contest_type_text }}</label>
                        <select class="form-control" name="status" id="">
                            <option @selected($contest->status == 0) value="0"> Đóng {{ $contest_type_text }} </option>
                            <option @selected($contest->status == 1) value="1"> Mở đang Mở </option>
                        </select>
                    </div> --}}
                    {{-- @error('status')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror --}}
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
    <script src="assets/js/system/date-after/date-after.js"></script>
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
        preview.showFile('#file-input', '#image-preview');
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
