@extends('layouts.main')
@section('title', 'Bàn làm việc')
@section('page-title', 'Bàn làm việc')
@section('content')
    @foreach ($contestsDealineNow as $item)
        <div class="alert alert-dismissible bg-info d-flex flex-column flex-sm-row w-100 p-5 mb-10">
            <!--begin::Icon-->
            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
            <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3"
                        d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z"
                        fill="black"></path>
                    <path
                        d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z"
                        fill="black"></path>
                </svg>
            </span>
            <!--end::Svg Icon-->
            <!--end::Icon-->
            <!--begin::Content-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <h4 class="mb-2 text-light">Thông báo</h4>
                <span>{{ $item->type == 1 ? 'Đánh giá năng lực ' : 'Cuộc thi ' }} {{ $item->name }} sẽ kết thúc vào hôm
                    nay
                    {{ $item->register_deadline }}</span>
            </div>
            <!--end::Content-->
            <!--begin::Close-->
            <button type="button"
                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                data-bs-dismiss="alert">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                <span class="svg-icon svg-icon-2x svg-icon-light">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="black"></rect>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="black"></rect>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </button>
            <!--end::Close-->
        </div>
    @endforeach

    <div class="row">
        <div class="col-xl-4 mb-5 mb-xl-10">
            <div class="card card-flush h-xl-100">
                <!--begin::Heading-->
                <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
                    style="background-image:url('assets/media/svg/shapes/top-green.png')">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column text-white pt-15">
                        <span class="fw-bolder fs-2x mb-3">Xin chào, {{ Auth::user()->name }}</span>
                        <div class="fs-4 text-white">
                            <span class="opacity-75">Thông tin tổng quan hệ thống</span>
                        </div>
                    </h3>
                </div>
                <div class="card-body mt-n20">
                    <div class="mt-n20 position-relative">
                        <div class="row g-3 g-lg-6">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Items-->
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-30px me-5 mb-8">
                                        <span class="symbol-label">
                                            <!--begin::Svg Icon | path: icons/duotune/medicine/med005.svg-->
                                            <i class="las fs-2x text-primary la-award"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Stats-->
                                    <div class="m-0">
                                        <!--begin::Number-->
                                        <span
                                            class="text-gray-700 fw-boldest d-block fs-2qx lh-1 mb-1">{{ number_format($totalContestGoingOn, 0) }}</span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span class="text-gray-500 fw-bold fs-6">Cuộc thi đang diễn ra</span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Items-->
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-30px me-5 mb-8">
                                        <span class="symbol-label">
                                            <!--begin::Svg Icon | path: icons/duotune/finance/fin001.svg-->
                                            <i class="las fs-2x text-success la-users"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Stats-->
                                    <div class="m-0">
                                        <!--begin::Number-->
                                        <span
                                            class="text-gray-700 fw-boldest d-block fs-2qx lh-1 mb-1">{{ $totalTeamActive }}</span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span class="text-gray-500 fw-bold fs-6">Đội đăng ký</span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Items-->
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-30px me-5 mb-8">
                                        <span class="symbol-label">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen020.svg-->
                                            <i class="las fs-2x text-success la-graduation-cap"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Stats-->
                                    <div class="m-0">
                                        <!--begin::Number-->
                                        <span
                                            class="text-gray-700 fw-boldest d-block fs-2qx lh-1 mb-1">{{ $totalStudentAccount }}</span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span class="text-gray-500 fw-bold fs-6">Sinh viên tham gia hệ thống</span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Body-->
            </div>
        </div>

        <div class="col-xl-8 mb-5 mb-xl-10">
            <!--begin::Chart widget 18-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-gray-800">Danh sách đội đăng ký thi</span>
                        <span class="text-gray-400 mt-1 fw-bold fs-6"></span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                        <input class="form-control form-control-solid" placeholder="Pick date rage"
                            id="daterange_picker_chart" />
                        <!--end::Daterangepicker-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body d-flex flex-column justify-content-between pt-3 pb-5">
                    <!--begin::Chart-->
                    <div id="kt_charts_widget_18_chart" class="h-400px min-h-auto"></div>
                    <!--end::Chart-->
                </div>
                <!--end: Card Body-->
            </div>
            <!--end::Chart widget 18-->
        </div>
        <div class="col-xl-4 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class=" ">
                <!--begin::Card-->
                <div class="card card-flush h-lg-100">
                    <!--begin::Card header-->
                    <div class="card-header mt-6">
                        <!--begin::Card title-->
                        <div class="card-title flex-column">
                            <h3 class="fw-bolder mb-1">Xếp hạng cuộc thi  </h3>
                        </div>
                        <div  style="width:65%;margin-top:7px" class="form-group p-2">
                                <select id="selectContest" class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                                    data-hide-search="false" tabindex="-1" aria-hidden="true" name="" value="">
                                    @if(count($dataContest)>0)
                                        @foreach($dataContest as $item )
                                            <option  @selected(request('old_contest') == $item->id)
                                                    value="{{$item->id}}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                        </div>
                    </div>
                    <div
                        style=" max-height: 500px;  overflow: auto;margin:0"
                        class="card-body p-9 pt-4">
                       <div id="rank-contest">
                            @if(count($listRankContest) >0 )
                                @foreach ($listRankContest as  $item)
                                    <h5 style="text-align: center;">{{ $item->name }}</h5>
                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                        <thead>
                                            <tr class="fw-bolder fs-6 text-gray-800">
                                                <th>Hạng</th>
                                                <th>Đội thi</th>
                                                <th>Tổng điểm</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dataTable">
                                            @if(count($item->results) > 0)
                                                @foreach ($item->results as $index => $result)
                                                    <tr>
                                                        <td
                                                            style="color: #0e0759;
                                                            font-size: 16px;
                                                            line-height: 22.4px;
                                                            font-weight: 400;
                                                            vertical-align: middle;
                                                            height: 60px;
                                                            padding: 10px;"
                                                        >{{ ++$index }}
                                                        </td>
                                                        <td>
                                                            <img
                                                                style="border-radius: 100px;
                                                                object-fit: cover;
                                                                display: inline-block;
                                                                height: 50px;
                                                                width: 50px;
                                                                "
                                                                src="{{ $result->team->image ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRI7M4Z0v1HP2Z9tZmfQaZFCuspezuoxter_A&usqp=CAU' }}"
                                                            >
                                                        <span
                                                                style="display: inline-block;
                                                                color: #0e0759;
                                                                margin: 0 0 0 10px;
                                                                font-size: 14px;
                                                                line-height: 22.4px;
                                                                font-weight: 400;"
                                                        >
                                                                {{$result->team->name ?? 'Không tồn tại'}}
                                                            </span>
                                                        </td>
                                                        <td
                                                            style="color: var(--my-primary);
                                                            font-size: 15px;
                                                            line-height: 22.4px;
                                                            font-weight: 400;
                                                            vertical-align: middle;
                                                            text-align: center;
                                                            height: 60px;
                                                            padding: 10px;"
                                                        >
                                                            {{$result->point}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            <h5>Không có bảng xếp hạng</h5>
                                            @endif
                                        </tbody>
                                    </table>
                                    <hr>
                                @endforeach
                            @endif
                       </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        </div>
        <div class="col-xl-4 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class=" ">
                <!--begin::Card-->
                <div class="card card-flush h-lg-100">
                    <!--begin::Card header-->
                    <div class="card-header mt-6">
                        <!--begin::Card title-->
                        <div class="card-title flex-column">
                            <h3 class="fw-bolder mb-1">Xếp hạng test năng lực  </h3>
                        </div>
                    </div>

                    <div style=" max-height: 500px;  overflow: auto;" class="card-body p-9 pt-4">
                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800">
                                    <th>Hạng</th>
                                    <th>Sinh viên</th>
                                    <th>Tổng điểm</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($listRankCapacity) > 0)
                                    @foreach ($listRankCapacity as $index => $item)
                                        <tr>
                                            <td
                                                style="color: #0e0759;
                                                font-size: 16px;
                                                line-height: 22.4px;
                                                font-weight: 400;
                                                vertical-align: middle;
                                                height: 60px;
                                                padding: 10px;"
                                            >{{ ++$index }}
                                            </td>
                                            <td>
                                                <img
                                                    style="border-radius: 100px;
                                                    object-fit: cover;
                                                    display: inline-block;
                                                    height: 50px;
                                                    width: 50px;
                                                    "
                                                    src="{{$item->user->avatar}}"
                                                >
                                               <span
                                                    style="display: inline-block;
                                                    color: #0e0759;
                                                    margin: 0 0 0 10px;
                                                    font-size: 14px;
                                                    line-height: 22.4px;
                                                    font-weight: 400;"
                                               >
                                                    {{$item->user->name}}
                                                </span>
                                            </td>
                                            <td
                                                style="color: var(--my-primary);
                                                font-size: 15px;
                                                line-height: 22.4px;
                                                font-weight: 400;
                                                vertical-align: middle;
                                                text-align: center;
                                                height: 60px;
                                                padding: 10px;"
                                            >
                                                {{$item->total_scores}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        </div>
        <div class="col-xl-4 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class=" ">
                <!--begin::Card-->
                <div class="card card-flush h-lg-100">
                    <!--begin::Card header-->
                    <div class="card-header mt-6">
                        <!--begin::Card title-->
                        <div class="card-title flex-column">
                            <h3 class="fw-bolder mb-1">Top 10 bài đánh giá năng lực có lượt tham gia nhiều </h3>
                        </div>
                    </div>

                    <div style=" max-height: 500px;  overflow: auto;" class="card-body p-9 pt-4">
                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800">
                                    <th>Hạng</th>
                                    <th>Bài Đánh giá</th>
                                    <th>Sv tham gia</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($listTopCapacity as $index => $item)
                                    <tr>
                                        <td
                                            style="color: #0e0759;
                                            font-size: 16px;
                                            line-height: 22.4px;
                                            font-weight: 400;
                                            vertical-align: middle;
                                            height: 60px;
                                            padding: 10px;"
                                        >{{ ++$index }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.contest.show.capatity', $item->id) }}">
                                                {{$item->name}}
                                             </a>
                                        </td>
                                        <td>
                                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo4/dist/../src/media/svg/icons/Communication/Group.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path
                                                            d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path
                                                            d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                            fill="#000000" fill-rule="nonzero" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                            {{ $item->result_capacity_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        </div>
        @if (auth()->user()->hasRole(config('util.ROLE_ADMINS')))
            <div class="col-xl-4 mb-5 mb-xl-10">
                <!--begin::Col-->
                <div class=" ">
                    <!--begin::Card-->
                    <div class="card card-flush h-lg-100">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h3 class="fw-bolder mb-1">Hoạt động cuộc thi và đánh giá năng lực </h3>

                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            {{-- <div class="card-toolbar">
                                <!--begin::Select-->
                                <select name="status" data-control="select2" data-hide-search="true"
                                    class="form-select form-select-solid form-select-sm fw-bolder w-100px">
                                    <option value="1" selected="selected">Options</option>
                                    <option value="2">Option 1</option>
                                    <option value="3">Option 2</option>
                                    <option value="4">Option 3</option>
                                </select>
                                <!--end::Select-->
                            </div> --}}
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div style=" max-height: 500px;  overflow: auto;" class="card-body p-9 pt-4">
                            <!--begin::Dates-->
                            <ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2">

                                <!--begin::Date-->
                                @foreach ($period as $key => $date)
                                    <li class="nav-item me-1">
                                        <button data-date="{{ $date->format('Y-m-d') }}"
                                            class="click-showtab nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3  {{ $date == $timeNow ? 'btn-active-warning  ' : '' }}  {{ $date == $timeNow ? 'btn-active-primary active' : '' }}"
                                            data-bs-toggle="tab" href="#kt_schedule_day_1">
                                            <span class="opacity-50 fs-7 fw-bold">{{ $date->format('l') }}</span>
                                            <span class="fs-6 fw-bolder">{{ $date->format('Y-m-d') }}</span>
                                        </button>
                                    </li>
                                @endforeach

                                <!--end::Date-->
                            </ul>
                            <!--end::Dates-->
                            <!--begin::Tab Content-->
                            <div class="tab-content">

                                <!--begin::Day-->
                                <div id="kt_schedule_day_1" class="tab-pane fade show active">

                                </div>
                                <!--end::Day-->

                            </div>
                            <!--end::Tab Content-->

                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
            </div>
        @endif
        {{-- <div class="col-xl-12 mb-5 mb-xl-12">
            <!--begin::Chart widget 18-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-gray-800">Lịch trình cuộc thi </span>
                        <span class="text-gray-400 mt-1 fw-bold fs-6"></span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                        <!--end::Daterangepicker-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body d-flex flex-column justify-content-between pt-3 pb-5">
                    <div id="kt_docs_vistimeline_style"></div>
                </div>
                <!--end: Card Body-->
            </div>
            <!--end::Chart widget 18-->
        </div> --}}
    </div>
    <input type="hidden" id="url_chart_data" value="{{ route('dashboard.chart-competity') }}">
@endsection
@section('page-script')
    <script src="{{ asset('assets/js/system/dashboard/chart-cuoc-thi.js') }}"></script>
    <script src="{{ asset('assets/js/system/dashboard/dashboard.js') }}"></script>
    <link href="assets/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" />
    <script src="assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
    <script>
        dashboardPage.initPage();

        var container = document.getElementById("kt_docs_vistimeline_style");

        // Generate HTML content
        const getContent = (title, img) => {
            const item = document.createElement('div');
            const name = document.createElement('div');
            const nameClasses = ['fw-bolder', 'mb-2'];
            name.classList.add(...nameClasses);
            name.innerHTML = title;

            const image = document.createElement('img');
            image.setAttribute('src', img);

            const symbol = document.createElement('div');
            const symbolClasses = ['symbol', 'symbol-circle', 'symbol-30'];
            symbol.classList.add(...symbolClasses);
            symbol.appendChild(image);

            item.appendChild(name);
            item.appendChild(symbol);

            return item;
        }

        // note that months are zero-based in the JavaScript Date object
        var items = new vis.DataSet(@json($contests));

        var options = {
            editable: false,
            margin: {
                item: 40,
                axis: 40,
            },
        };

        var timeline = new vis.Timeline(container, items, options);
    </script>

    <script>
        fetchConTestCapacity("{{ $timeNow }}");

        function fetchConTestCapacity(date) {
            $('#kt_schedule_day_1').html(`Đang chạy ...`);
            $.ajax({
                type: "GET",
                url: "admin/contest-capacity?date=" + date,
                success: function(response) {
                    var html = response.payload.map(function(data) {
                        return `
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <!--begin::Bar-->
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                    <!--end::Bar-->
                                    <!--begin::Info-->
                                    <div class="fw-bold ms-5 text-gray-600">
                                        <!--begin::Time-->
                                        <div class="fs-5">
                                            ${data.date_start} - ${data.register_deadline}
                                        </div>
                                        <!--end::Time-->
                                        <!--begin::Title-->
                                        <a href="${data.type == 1 ? '/admin/capacity/'+data.id : '/admin/contest/'+data.id+'/detail'}"
                                            class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">
                                               ${data.type == 1 ? 'Đánh giá năng lực : ' : 'Cuộc thi : '} ${data.name}
                                        </a>
                                        <!--end::Title-->
                                        <!--begin::User-->
                                        <div class="text-gray-400">
                                            <a href="#">${data.type == 1 ? 'Đánh giá năng lực' : 'Cuộc thi'}</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Action-->
                                    <a href="${data.type == 1 ? '/admin/capacity/'+data.id : '/admin/contests/'+data.id+'/detail'}" class="btn btn-bg-light btn-active-color-primary btn-sm">Xem chi tiết </a>
                                    <!--end::Action-->
                                </div>

                        `;
                    }).join(" ");
                    $('#kt_schedule_day_1').html(html);
                }
            });
        }
        $('.click-showtab').on('click', function() {

            fetchConTestCapacity($(this).data('date'))
        })
    </script>

@endsection
