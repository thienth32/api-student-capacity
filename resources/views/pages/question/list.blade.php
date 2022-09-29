@extends('layouts.main')
@section('title', 'Quản lý bộ câu hỏi')
@section('page-title', 'Quản lý bộ câu hỏi')
@section('content')



    <div class="card card-flush p-4">
        <div class="row mb-4">
            <div class=" col-lg-6">

                <h1>Danh sách bộ câu hỏi
                    <span data-bs-toggle="tooltip" title="Tải lại trang " role="button"
                        class="refresh-btn svg-icon svg-icon-primary svg-icon-2x">
                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Update.svg--><svg
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z"
                                    fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <a href="{{ route('admin.question.soft.delete', 'question_soft_delete=1') }}">
                        <span data-bs-toggle="tooltip" title="Kho lưu trữ bản xóa " role="button"
                            class="svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                    <path
                                        d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                        </span>
                    </a>
                </h1>
            </div>
            <div class=" col-lg-6">
                <div class="gap-1 d-flex justify-content-end bd-highlight">

                    <div>
                        <a href="{{ route('admin.question.create') }}" class=" btn btn-primary">
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                        rx="1" transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="black"></rect>
                                </svg>
                            </span>
                            Tạo mới câu hỏi
                        </a>
                    </div>
                    <div>
                        <a class=" btn btn-primary" target="_blank" href="{{ route('admin.download.execel.pass') }}">
                            <span class="svg-icon svg-icon-x svg-icon-primary   ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path opacity="0.3"
                                        d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                        fill="black"></path>
                                    <path
                                        d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                        fill="black"></path>
                                </svg>
                            </span>
                            Tải
                            xuống mẫu</a>
                    </div>

                    <div class="ms-4">
                        {{-- <form action="{{ route('admin.question.excel.import') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf --}}
                        <label data-bs-toggle="modal" data-bs-target="#kt_modal_1" type="button"
                            class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">
                            <!--begin::Svg Icon | path: icons/duotune/files/fil013.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="black">
                                    </path>
                                    <path
                                        d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.2C9.7 3 10.2 3.20001 10.4 3.60001ZM16 12H13V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V12H8C7.4 12 7 12.4 7 13C7 13.6 7.4 14 8 14H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z"
                                        fill="black"></path>
                                    <path opacity="0.3"
                                        d="M11 14H8C7.4 14 7 13.6 7 13C7 12.4 7.4 12 8 12H11V14ZM16 12H13V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z"
                                        fill="black"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Tải lên Excel
                        </label>

                    </div>
                </div>
            </div>
        </div>
        {{--  --}}

        <div class="row card-format">

            <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                <div class="   form-group ">
                    <label class="form-label">Skill</label>
                    <select id="selectSkill" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="0">Chọn skill</option>
                        @foreach ($skills as $skill)
                            <option @selected(request('skill') == $skill->id) value="{{ $skill->id }}">
                                {{ $skill->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                <div class="form-group">
                    <label class="form-label">Level</label>
                    <select id="select-level" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="true" tabindex="-1" aria-hidden="true">
                        {{-- <option @selected(request()->has('status') && request('status') == 0) value="0">Không kích hoạt
                        </option>
                        <option @selected(request('status') == 1) value="1">Kích họat
                        </option> --}}
                        <option value="3" @selected(!request()->has('level'))>Chọn level</option>
                        <option @selected(request()->has('level') && request('level') == 0) value="0">Dễ</option>
                        <option @selected(request()->has('level') && request('level') == 1) value="1">Trung bình</option>
                        <option @selected(request()->has('level') && request('level') == 2) value="2">Khó</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                <div class="form-group">
                    <label class="form-label">Loại</label>
                    <select id="select-type" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="3" @selected(!request()->has('type'))>Chọn loại</option>
                        <option @selected(request()->has('type') && request('type') == 0) value="0">Một đáp án</option>
                        <option @selected(request()->has('type') && request('type') == 1) value="1">Nhiều đáp án</option>

                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-2 col-sx-12 col-md-12 col-sm-12 col-xxl-2 col-xl-2">
                <div class="form-group">
                    <label class="form-label">Trạng thái</label>
                    <select id="select-status" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="3" @selected(!request()->has('status'))>Chọn trạng thái</option>
                        <option @selected(request()->has('status') && request('status') == 0) value="0">Không kích hoạt
                        </option>
                        <option @selected(request('status') == 1) value="1">Kích họat
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="  form-group">
                    <label class="form-label">Tìm kiếm </label>
                    <input type="text" value="{{ request('q') ?? '' }}" placeholder="*Enter tìm kiếm ..."
                        class=" ip-search form-control">
                </div>
            </div>

        </div>

        {{--  --}}
        <div>
            <div class="back">

                <span data-bs-toggle="tooltip" title="Đóng lọc" class="btn-hide svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Stockholm-icons/Navigation/Angle-up.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                </span>

                <span data-bs-toggle="tooltip" title="Mở lọc" class="btn-show svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero"
                                transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) " />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>

            </div>
        </div>

        <div class="table-responsive table-responsive-md">
            @if (count($questions) > 0)
                <table class="table table-row-bordered  table-row-gray-100 gy-1 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nội dung câu hỏi
                                <a
                                    href="{{ route('admin.teams', [
                                        'sort_by' => request()->has('sort_by') ? (request('sort_by') == 'desc' ? 'asc' : 'desc') : 'asc',
                                        'orderBy' => 'name',
                                    ]) }}">
                                    <span role="button" data-key="name" data-bs-toggle="tooltip"
                                        title="Lọc theo nội dung câu hỏi "
                                        class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            style="width: 14px !important ; height: 14px !important" width="24px"
                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                    x="5" y="5" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                    x="17" y="7" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) " />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </a>

                            </th>
                            <th scope="col">Level câu hỏi</th>
                            <th scope="col">Loại</th>
                            <th class=" text-center" scope="col">Skill</th>
                            <th scope="col">Trạng thái </th>
                            <th scope="col">Ngày tạo
                                <a
                                    href="{{ route('admin.question.index', [
                                        'sortBy' => request()->has('sortBy') ? (request('sortBy') == 'desc' ? 'asc' : 'desc') : 'asc',
                                        'orderBy' => 'created_at',
                                    ]) }}">
                                    <span role="button" data-key="end_time" data-bs-toggle="tooltip"
                                        title="Lọc theo ngày tạo "
                                        class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            style="width: 14px !important ; height: 14px !important" width="24px"
                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                                    x="5" y="5" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                                    x="17" y="7" width="2" height="12"
                                                    rx="1" />
                                                <path
                                                    d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) " />
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                            </th>
                            <th class="text-center" colspan="2">
                                Thao tác
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = $questions->total();
                        @endphp
                        @forelse ($questions as $key => $question)
                            @php
                                $token = uniqid(15);
                            @endphp
                            <tr>

                                <td style="width:30%">
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default mb-5">
                                            <div class="panel-heading" role="tab" id="heading{{ $token }}">
                                                <h6 class="panel-title">
                                                    <div role="button" data-toggle="collapse" data-parent="#accordion"
                                                        aria-expanded="true" aria-controls="collapse{{ $token }}">
                                                        {!! $question->content !!}
                                                    </div>
                                                </h6>
                                            </div>
                                            <div id="collapse{{ $token }}" class="panel-collapse collapse"
                                                role="tabpanel" aria-labelledby="heading{{ $token }}">
                                                <div class="panel-body">
                                                    <ul class="list-group list-group-flush">
                                                        @if (count($question->answers) > 0)
                                                            @foreach ($question->answers as $answer)
                                                                <li
                                                                    class="list-group-item {{ $answer->is_correct == config('util.ANSWER_TRUE') ? 'active' : '' }}">
                                                                    {{ $answer->content }}</li>
                                                            @endforeach
                                                        @endif

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>

                                <td style="width:10%">
                                    <button class="btn btn-info btn-sm">
                                        @if ($question->rank == config('util.RANK_QUESTION_EASY'))
                                            Dễ
                                        @elseif ($question->rank == config('util.RANK_QUESTION_MEDIUM'))
                                            Trung bình
                                        @elseif ($question->rank == config('util.RANK_QUESTION_DIFFICULT'))
                                            Khó
                                        @endif
                                    </button>
                                </td>
                                <td>
                                    @if ($question->type == config('util.INACTIVE_STATUS'))
                                        Một đáp án
                                    @else
                                        Nhiều đáp án
                                    @endif
                                </td>
                                <td style="width:15%">
                                    <div class="d-grid gap-2">
                                        @if ($question->skills)
                                            @foreach ($question->skills as $skill)
                                                <button class=" btn-color-dark btn btn-secondary btn-sm" type="button">
                                                    {{ $skill->name }}
                                                </button>
                                            @endforeach
                                        @endif
                                    </div>

                                </td>
                                <td>
                                    <div data-bs-toggle="tooltip" title="Cập nhật trạng thái "
                                        class="form-check form-switch">
                                        <input value="{{ $question->status }}" data-id="{{ $question->id }}"
                                            class="form-select-status form-check-input " @checked($question->status == 1)
                                            type="checkbox" role="switch">
                                    </div>
                                </td>
                                <td>{{ $question->created_at }}</td>
                                <td>
                                    @hasanyrole(config('util.ROLE_ADMINS'))

                                        <div data-bs-toggle="tooltip" title="Thao tác " class="btn-group dropstart">
                                            <button type="button" class="btn   btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="svg-icon svg-icon-success svg-icon-2x">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24"
                                                                height="24" />
                                                            <path
                                                                d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                                fill="#000000" />
                                                        </g>
                                                    </svg>
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu  px-4 ">
                                                <li class="my-3">
                                                    <a href="{{ route('admin.question.edit', ['id' => $question->id]) }}">
                                                        <span role="button" class="svg-icon svg-icon-success svg-icon-2x">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24"
                                                                        height="24" />
                                                                    <path
                                                                        d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                                    <rect fill="#000000" opacity="0.3" x="5"
                                                                        y="20" width="15" height="2"
                                                                        rx="1" />
                                                                </g>
                                                            </svg>
                                                        </span>
                                                        Chỉnh sửa
                                                    </a>
                                                </li>

                                                <li class="my-3">

                                                    <form
                                                        action="{{ route('admin.question.destroy', ['id' => $question->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button onclick="return confirm('Bạn có chắc muốn xóa không !')"
                                                            style=" background: none ; border: none ; list-style : none"
                                                            type="submit">
                                                            <span role="button" class="svg-icon svg-icon-danger svg-icon-2x">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24"
                                                                            height="24" />
                                                                        <path
                                                                            d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"
                                                                            fill="#000000" fill-rule="nonzero" />
                                                                        <path
                                                                            d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                                            fill="#000000" opacity="0.3" />
                                                                    </g>
                                                                </svg>

                                                            </span>
                                                            Thùng rác
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>

                                    @endhasrole
                                </td>

                            </tr>

                        @empty
                        @endforelse
                    </tbody>
                </table>
                {{ $questions->appends(request()->all())->links('pagination::bootstrap-4') }}
            @else
                <h2>Câu hỏi chưa cập nhập !!!</h2>
            @endif
        </div>



        <div class="modal fade" tabindex="-1" id="kt_modal_1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tải lên </h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>
                    <form class="form-submit" action="{{ route('admin.question.excel.import') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body text-center">
                            <div class="HDSD">
                            </div>
                            <label for="up-file" class="">
                                <i data-bs-toggle="tooltip" title="Click để upload file" style="font-size: 100px;"
                                    role="button" class="bi bi-cloud-plus-fill"></i>
                            </label>
                            <input style="display: none" type="file" name="ex_file" id="up-file">
                            <div style="display: none" class="progress show-p mt-3 h-25px w-100">
                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                    role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <p class="show-name"></p>
                            <p class="text-danger error_ex_file"></p>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="upload-file btn btn-primary">Tải lên </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')

    <script>
        let url = "/admin/questions?";
        const _token = "{{ csrf_token() }}";
        const sort = '{{ request()->has('sort') ? (request('sort') == 'desc' ? 'asc' : 'desc') : 'asc' }}';
        const start_time =
            '{{ request()->has('start_time') ? \Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const end_time =
            '{{ request()->has('end_time') ? \Carbon\Carbon::parse(request('end_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
    </script>

    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script src="{{ asset('assets/js/system/question/index.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        question.selectChangeStatus(
            ".form-select-status"
        );
        question.selectSkillList('#selectSkill');
        question.selectLevelList('#select-level');
        question.selectTypeList('#select-type');
    </script>
    <script>
        $(document).ready(function() {
            $('#up-file').on("change", function() {
                $('.show-name').html($(this)[0].files[0].name);
            })
            $('.form-submit').ajaxForm({
                beforeSend: function() {
                    $(".error_ex_file").html("");
                    $(".upload-file").html("Đang tải dữ liệu ..")
                    $(".progress").show();
                    var percentage = '0';
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage + '%', function() {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                },
                success: function() {
                    $(".progress").hide();
                    $(".upload-file").html("Tải lên")
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    $(".upload-file").html("Tải lên")
                    $('.progress .progress-bar').css("width", 0 + '%', function() {
                        return $(this).attr("aria-valuenow", 0) + "%";
                    })
                    $(".progress").hide();
                    var err = JSON.parse(xhr.responseText);
                    if (err.errors) $(".error_ex_file").html(err.errors.ex_file);
                }
            });

            $(".panel-heading").parent('.panel').hover(
                function() {
                    $(this).children('.collapse').collapse('show');
                },
                function() {
                    $(this).children('.collapse').collapse('hide');
                }
            );


        })
    </script>

@endsection
