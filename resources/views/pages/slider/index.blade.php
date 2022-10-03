@extends('layouts.main')
@section('title', 'Quản lý slider')
@section('page-title', 'Quản lý slider')
@section('content')

    {{-- {{ dd(\Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A')) }} --}}
    <div class="card card-flush p-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex justify-content-start">

                    <h1>Danh sách slider
                    </h1>
                    <span data-bs-toggle="tooltip" title="Tải lại trang " role="button"
                        class="mx-2 refresh-btn svg-icon svg-icon-primary svg-icon-2x">
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
                    <a class="mx-2" href="{{ route('admin.sliders.soft.delete', 'slider_soft_delete=1') }}">

                        <span data-bs-toggle="tooltip" title="Kho lưu trữ bản xóa "
                            class=" svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Files/Deleted-folder.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M10.5857864,14 L9.17157288,12.5857864 C8.78104858,12.1952621 8.78104858,11.5620972 9.17157288,11.1715729 C9.56209717,10.7810486 10.1952621,10.7810486 10.5857864,11.1715729 L12,12.5857864 L13.4142136,11.1715729 C13.8047379,10.7810486 14.4379028,10.7810486 14.8284271,11.1715729 C15.2189514,11.5620972 15.2189514,12.1952621 14.8284271,12.5857864 L13.4142136,14 L14.8284271,15.4142136 C15.2189514,15.8047379 15.2189514,16.4379028 14.8284271,16.8284271 C14.4379028,17.2189514 13.8047379,17.2189514 13.4142136,16.8284271 L12,15.4142136 L10.5857864,16.8284271 C10.1952621,17.2189514 9.56209717,17.2189514 9.17157288,16.8284271 C8.78104858,16.4379028 8.78104858,15.8047379 9.17157288,15.4142136 L10.5857864,14 Z"
                                        fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </a>
                </div>

            </div>
            <div class=" col-lg-6">
                <div class=" d-flex flex-row-reverse bd-highlight">
                    <a href="{{ route('admin.sliders.create') }}" class=" btn btn-primary">Thêm mới slider
                    </a>
                </div>
            </div>
        </div>

        <div class="row card-format">
            <div class="col-12 col-lg-8 col-sx-12 col-md-12 col-sm-12 col-xxl-8 col-xl-8">
                <div class="   ">
                    <label class="form-label">Tình trạng </label>
                    <select id="select-status" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="3" @selected(!request()->has('status'))>Chọn tình trạng </option>
                        <option @selected(request('status') == 1) value="1">Kích họat
                        </option>
                        <option @selected(request()->has('status') && request('status') == 0) value="0">Không kích hoạt
                        </option>
                    </select>
                </div>
            </div>
            {{-- <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="">
                    <label class="form-label">Chuyên ngành </label>
                    <select id="select-major" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                        data-hide-search="true" tabindex="-1" aria-hidden="true">
                        <option value="0">Chọn chuyên ngành </option>
                        @forelse ($majors as $major)
                            <option @selected(request('major_id') == $major->id) value="{{ $major->id }}">{{ $major->name }}
                            </option>
                        @empty
                            <option>-- Không có chuyên ngành --</option>
                        @endforelse
                    </select>
                </div>
            </div> --}}
            <div class="col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4">
                <div class="">
                    <label class="form-label">Tìm kiếm </label>
                    <input type="text" value="{{ request('q') ?? '' }}" placeholder="*Enter tìm kiếm ..."
                        class=" ip-search form-control">
                </div>
            </div>
            <div class="col-12 row">
                <label class="form-label">Lọc theo thành phần </label>
                <div class="row col-12 m-auto">
                    <button
                        class="btn-home-re {{ request()->has('home') ? 'btn-primary' : '' }} btn col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4 btn-light">Banner
                        thuộc trang chủ </button>
                    <button
                        class="btn-major {{ request()->has('major') ? 'btn-primary' : '' }} btn col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4 btn-light">Banner
                        thuộc chuyên ngành</button>
                    <button
                        class="btn-round {{ request()->has('round') ? 'btn-primary' : '' }} btn col-12 col-lg-4 col-sx-12 col-md-12 col-sm-12 col-xxl-4 col-xl-4 btn-light">Banner
                        thuộc vòng thi</button>


                </div>
                <div class="col-12 pb-2">
                    <div style="{{ request()->has('major') ? '' : 'display: none' }} " id="major">
                        <label class="form-label">Chuyên ngành</label>
                        <select id="select-major" name="major_id" class="form-select form-major" data-control="select2"
                            data-placeholder="Chọn chuyên ngành ">
                            <option value="0">Chọn chuyên ngành</option>
                            @foreach ($majors as $major)
                                <option @selected(request('major_id') == $major->id) value="{{ $major->id }}">{{ $major->name }} -
                                    {{ $major->sliders_count . ' banner' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="{{ request()->has('round') ? '' : 'display: none' }}" id="round">
                        {{--  --}}

                        <label class="form-label">Cuộc thi </label>
                        <select id="select-contest-p" class="form-select form-contest " data-control="select2"
                            data-placeholder="Chọn vòng thi ">
                            <option value="0">Chọn cuộc thi</option>
                            @foreach ($contests as $contest)
                                <option @selected(($round ? $round->contest->id : 0) == $contest->id) value="{{ $contest->id }}">{{ $contest->name }} -
                                    {{ $contest->rounds_count . ' vòng thi ' }}
                                </option>
                            @endforeach
                        </select>

                        <div>
                            <label class="form-label">Vòng thi </label>
                            <select id="select-round" name="round_id" class="form-select form-round "
                                data-control="select2" data-placeholder="Chọn vòng thi ">
                                @if (request()->has('round') && request()->has('round_id'))
                                    <option value="0">Chọn vòng thi</option>
                                    @foreach ($rounds as $r)
                                        @if (($round ? $round->contest->id : 0) == $r->contest_id)
                                            <option @selected(request('round_id') == $r->id) value="{{ $r->id }}">
                                                {{ $r->name }}
                                                -
                                                {{ $r->sliders_count . ' banner ' }}
                                            </option>
                                        @endif
                                    @endforeach
                                @else
                                    <option disabled value="0">Không có vòng thi nào ! Hãy chọn cuộc thi </option>
                                @endif
                            </select>
                        </div>

                        {{--  --}}
                    </div>
                </div>
            </div>
            <br>
            <div class="col-12 row ">
                <label class="form-label">Lọc theo thời gian </label>
                <div class="col-12 row m-auto">
                    <button
                        class="btn-light col-12 col-lg-6 col-sx-12 col-md-12 col-sm-12 col-xxl-6 col-xl-6 click-time-local {{ request()->has('start_time') && request()->has('end_time') ? ' btn-primary' : ' btn-default' }} btn ">
                        Thời
                        gian cụ thể </button>
                    <button
                        class="btn-light col-12 col-lg-6 col-sx-12 col-md-12 col-sm-12 col-xxl-6 col-xl-6 click-time {{ (request()->has('day') || request()->has('month') || request()->has('year')) && request()->has('op_time') ? 'btn-primary' : 'btn-default' }} btn ">Khoảng
                        thời gian</button>
                    <div class="show-time">
                        <div style="{{ request()->has('start_time') && request()->has('end_time') ? '' : 'display : none' }}"
                            id="time-local">
                            <div class="col-12  ">
                                <small class="small">Thời gian </small>
                                <input class="form-control " placeholder="Pick date rage" id="kt_daterangepicker_2" />
                            </div>
                        </div>
                        <div style="{{ (request()->has('day') || request()->has('month') || request()->has('year')) && request()->has('op_time') ? '' : 'display : none' }}"
                            id="time">
                            <div class="col-12  ">
                                <small for="" class="small">Khoảng thời gian </small>
                                <select class="select-date-serach form-control form-select mb-2 select2-hidden-accessible"
                                    data-control="select2" data-hide-search="true" tabindex="-1" aria-hidden="true">
                                    <option class="form-control">Chọn thời gian</option>
                                    <option class="form-control" @selected(request('day') == 7 && request('op_time') == 'add') value="add-day-7">7 Ngày
                                        tới
                                    </option>
                                    <option class="form-control" @selected(request('day') == 15 && request('op_time') == 'add') value="add-day-15">15
                                        Ngày
                                        tới </option>
                                    <option class="form-control" @selected(request('month') == 1 && request('op_time') == 'add') value="add-month-1">1
                                        Tháng
                                        tới
                                    </option>
                                    <option class="form-control" @selected(request('month') == 6 && request('op_time') == 'add') value="add-month-6">6
                                        Tháng
                                        tới
                                    </option>
                                    <option class="form-control" @selected(request('year') == 1 && request('op_time') == 'add') value="add-year-1">1 Năm
                                        tới
                                    </option>
                                    <option class="form-control" disabled> </option>
                                    <option class="form-control" @selected(request('day') == 7 && request('op_time') == 'sub') value="sub-day-7">7 Ngày
                                        trước </option>
                                    <option class="form-control" @selected(request('day') == 15 && request('op_time') == 'sub') value="sub-day-15">15
                                        Ngày
                                        trước
                                    </option>
                                    <option class="form-control" @selected(request('month') == 1 && request('op_time') == 'sub') value="sub-month-1">1
                                        Tháng
                                        trước
                                    </option>
                                    <option class="form-control" @selected(request('month') == 6 && request('op_time') == 'sub') value="sub-month-6">6
                                        Tháng
                                        trước
                                    </option>
                                    <option class="form-control" @selected(request('year') == 1 && request('op_time') == 'sub') value="sub-year-1">1
                                        Năm
                                        trước
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="back">
            <hr>
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

            <span data-bs-toggle="tooltip" title="Mở lọc" style="display: none"
                class="btn-show svg-icon svg-icon-primary svg-icon-2x">
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

        <div class="">
            <table class=" table table-row-bordered table-row-gray-300 gy-7  table-hover  ">
                <thead>
                    <tr>
                        {{-- <th scope="col">
                            <span role="button" data-key="id"
                                class=" svg-icon svg-icon-primary  svg-icon-2x format-database">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Up-down.svg--><svg
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    style="width: 14px !important ; height: 14px !important" width="24px" height="24px"
                                    viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24" />
                                        <rect fill="#000000" opacity="0.3"
                                            transform="translate(6.000000, 11.000000) rotate(-180.000000) translate(-6.000000, -11.000000) "
                                            x="5" y="5" width="2" height="12" rx="1" />
                                        <path
                                            d="M8.29289322,14.2928932 C8.68341751,13.9023689 9.31658249,13.9023689 9.70710678,14.2928932 C10.0976311,14.6834175 10.0976311,15.3165825 9.70710678,15.7071068 L6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 L2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 C2.68341751,13.9023689 3.31658249,13.9023689 3.70710678,14.2928932 L6,16.5857864 L8.29289322,14.2928932 Z"
                                            fill="#000000" fill-rule="nonzero" />
                                        <rect fill="#000000" opacity="0.3"
                                            transform="translate(18.000000, 13.000000) scale(1, -1) rotate(-180.000000) translate(-18.000000, -13.000000) "
                                            x="17" y="7" width="2" height="12" rx="1" />
                                        <path
                                            d="M20.2928932,5.29289322 C20.6834175,4.90236893 21.3165825,4.90236893 21.7071068,5.29289322 C22.0976311,5.68341751 22.0976311,6.31658249 21.7071068,6.70710678 L18.7071068,9.70710678 C18.3165825,10.0976311 17.6834175,10.0976311 17.2928932,9.70710678 L14.2928932,6.70710678 C13.9023689,6.31658249 13.9023689,5.68341751 14.2928932,5.29289322 C14.6834175,4.90236893 15.3165825,4.90236893 15.7071068,5.29289322 L18,7.58578644 L20.2928932,5.29289322 Z"
                                            fill="#000000" fill-rule="nonzero"
                                            transform="translate(18.000000, 7.500000) scale(1, -1) translate(-18.000000, -7.500000) " />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </th> --}}
                        <th>Url chuyển hướng </th>
                        <th>Banner </th>
                        <th>Thuộc thành phần </th>
                        <th>Tình trạng </th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc </th>
                        <th class="text-center" colspan="2">

                        </th>

                    </tr>
                </thead>
                <tbody>
                    {{-- @php

                        $total = $sliders->total() + 1;
                    @endphp --}}
                    @forelse ($sliders as $key => $slider)
                        <tr>
                            {{-- @if (request()->has('sort'))
                                <th scope="row">
                                    @if (request('sort') == 'desc')
                                        {{ (request()->has('page') && request('page') !== 1 ? $sliders->perPage() * (request('page') - 1) : 0) + $key + 1 }}
                                    @else
                                        {{ request()->has('page') && request('page') !== 1 ? $total - $sliders->perPage() * (request('page') - 1) - $key - 1 : ($total -= ($key == 0 ? 0 : 1)) }}
                                    @endif
                                </th>
                            @else
                                <th scope="row">
                                    {{ (request()->has('page') && request('page') !== 1 ? $sliders->perPage() * (request('page') - 1) : 0) + $key + 1 }}
                                </th>
                            @endif --}}
                            <td width="20%">
                                <p><span id="text_{{ $slider->id }}">{{ $slider->link_to }}
                                        <span data-bs-toggle="tooltip" title="Sao chép " class="coppyText p-3"
                                            data-key="{{ $slider->id }}" role="button">
                                            <span class="svg-icon svg-icon-dark svg-icon-2x">
                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Design/Substract.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24"
                                                            height="24" />
                                                        <path
                                                            d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z"
                                                            fill="#000000" fill-rule="nonzero" />
                                                        <path
                                                            d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>

                                </p>
                            </td>
                            <td>
                                <img style="width: 200px ; height: 100px;object-fit: cover;"
                                    src="{{ $slider->image_url ?? 'assets/media/avatars/blank.png' }}" alt="">
                            </td>
                            <td>
                                @if ($slider->sliderable)
                                    @if (get_class($slider->sliderable) == \App\Models\Round::class)
                                        Vòng thi : <b>{{ $slider->sliderable->name }}</b>
                                    @elseif (get_class($slider->sliderable) == \App\Models\Major::class)
                                        Chuyên ngành : <b>{{ $slider->sliderable->name }}</b>
                                    @endif
                                @else
                                    {{ 'Trang chủ ' }}
                                @endif
                            </td>

                            <td>

                                <div data-bs-toggle="tooltip" title="Cập nhật trạng thái "
                                    class="form-check form-switch">
                                    <input value="{{ $slider->status }}" data-id="{{ $slider->id }}"
                                        class="form-select-status form-check-input" @checked($slider->status == 1)
                                        type="checkbox" role="switch">
                                </div>

                            </td>
                            <td> {{ $slider->start_time }} <br>
                                {{ \Carbon\Carbon::parse($slider->start_time)->diffForHumans() }}</td>
                            <td> {{ $slider->end_time }} <br>
                                {{ \Carbon\Carbon::parse($slider->end_time)->diffForHumans() }}</td>
                            <td>
                                <div data-bs-toggle="tooltip" title="Thao tác " class="btn-group dropstart">
                                    <button style="padding: 0" type="button" class="btn   btn-sm dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="svg-icon svg-icon-success svg-icon-2x">
                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Settings-2.svg--><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path
                                                        d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                        fill="#000000" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu ps-3">
                                        <li class="my-3">
                                            <a href="{{ route('admin.sliders.edit', ['id' => $slider->id]) }}">
                                                <span role="button" class="svg-icon svg-icon-success svg-icon-2x">
                                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Design/Edit.svg--><svg
                                                        xmlns="http://www.w3.org/2000/svg"
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
                                            @hasrole(config('util.ROLE_DELETE'))
                                                <form action="{{ route('admin.sliders.destroy', ['id' => $slider->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Bạn có chắc muốn xóa không !')"
                                                        style=" background: none ; border: none ; list-style : none"
                                                        type="submit">
                                                        <span role="button" class="svg-icon svg-icon-danger svg-icon-2x">
                                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Trash.svg--><svg
                                                                xmlns="http://www.w3.org/2000/svg"
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
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                        Xóa bỏ
                                                    </button>
                                                </form>
                                            @else
                                                <span style="cursor: not-allowed; user-select: none"
                                                    class="svg-icon svg-icon-danger svg-icon-2x">
                                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Lock-circle.svg--><svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24"
                                                                height="24" />
                                                            <circle fill="#000000" opacity="0.3" cx="12"
                                                                cy="12" r="10" />
                                                            <path
                                                                d="M14.5,11 C15.0522847,11 15.5,11.4477153 15.5,12 L15.5,15 C15.5,15.5522847 15.0522847,16 14.5,16 L9.5,16 C8.94771525,16 8.5,15.5522847 8.5,15 L8.5,12 C8.5,11.4477153 8.94771525,11 9.5,11 L9.5,10.5 C9.5,9.11928813 10.6192881,8 12,8 C13.3807119,8 14.5,9.11928813 14.5,10.5 L14.5,11 Z M12,9 C11.1715729,9 10.5,9.67157288 10.5,10.5 L10.5,11 L13.5,11 L13.5,10.5 C13.5,9.67157288 12.8284271,9 12,9 Z"
                                                                fill="#000000" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                Xóa bỏ
                                            @endhasrole

                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            {{ $sliders->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>

    </div>



@endsection
@section('page-script')
    <script>
        let url = '/admin/sliders?';
        const _token = "{{ csrf_token() }}";
        const sort = '{{ request()->has('sort') ? (request('sort') == 'desc' ? 'asc' : 'desc') : 'asc' }}';
        const start_time =
            '{{ request()->has('start_time') ? \Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const end_time =
            '{{ request()->has('end_time') ? \Carbon\Carbon::parse(request('end_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const rounds = @json($rounds);
    </script>
    <script src="assets/js/system/formatlist/formatlis.js"></script>
    <script src="assets/js/system/slider/form.js"></script>
    <script src="assets/js/system/slider/slider.js"></script>
@endsection
