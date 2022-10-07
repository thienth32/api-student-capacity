@extends('layouts.main')
@section('title', 'Chi tiết vòng thi ')
@section('page-title', 'Chi tiết vòng thi ')
@section('content')
    <div class=" mb-4">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.contest.list') }}" class="pe-3">Cuộc thi </a>
                    </li>
                    <li class="breadcrumb-item px-3 ">
                        <a href="{{ route('admin.contest.show', ['id' => $round->contest->id]) }}" class="pe-3">
                            {{ $round->contest->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.contest.detail.round', ['id' => $round->contest_id]) }}"
                            class="pe-3">Vòng thi </a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">{{ $round->name }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 mb-5 mb-xl-10">
            <div class="card card-flush ">
                <!--begin::Heading-->
                <div class=" rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start "
                    style="background-image:url('assets/media/svg/shapes/top-green.png')">
                    <!--begin::Title-->
                    <div class="p-5">
                        <span class="fw-bolder text-white fs-2x mb-3">{{ $round->name }}</span>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <img style="width:100%"
                                    src="{{ $round['image'] ?? 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                    alt="">
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Cuộc thi </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $round->contest->name }}

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thể loại cuộc thi </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $round->type_exam->name }}

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thời gian bắt đầu</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($round->start_time)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($round->start_time)->diffforHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thời gian kết thúc</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($round->end_time)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($round->end_time)->diffforHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Trạng thái</h3>
                                    </div>
                                    <div class="col-8">
                                        @if ($contest->status == 1)
                                            <button type="button" class="btn btn-primary">
                                                Kích hoạt
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger">
                                                Không kích hoạt
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xl-8 mb-5 mb-xl-10">

            <div class="container-fluid  card card-flush">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="my-6">Mô tả vòng thi </h2>
                        <div class=" fs-3 pb-5">
                            {!! $round->description !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-1 card card-flush">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="my-6">Ban giám khảo</h2>
                        <div class=" fs-3 pb-5">
                            <ul class="list-group">
                                @forelse ($round -> judges as $judge)
                                    <li class="list-group-item"> {{ $judge->user->name }}
                                        <small class="badge bg-success">{{ $judge->user->email }}</small>
                                    </li>
                                @empty
                                    Không có ban giám khảo !
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class=" card card-flush ">
                        <div class="row p-5 d-flex justify-content-center align-items-center ">

                            @if (count($roundTeam) > 0)
                                <div class="col-md-3">
                                    <a href="{{ route('admin.round.detail.updateRoundTeam', ['id' => $round->id]) }}">
                                        <div
                                            class="badge badge-primary badge-pill bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                            <div class="m-0  ">
                                                <span class="text-white-700 fw-bold fs-6">Công bố đội thi</span>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if (count($round->teams) > 0)
                <div class="container-fluid mt-1 mb-2 card card-flush">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="my-6">Đội thi</h2>
                            <div class="back">
                                <hr>
                                <span class="btn-hide svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Stockholm-icons/Navigation/Angle-up.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                </span>

                                <span style="display: none" class="btn-show svg-icon svg-icon-primary svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Navigation/Angle-down.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                            <div class="list-team fs-3 pb-5">
                                <table class="table table-row-dashed table-row-gray-300 gy-7">
                                    <thead>
                                        <tr class="fw-bolder fs-6 text-gray-800">
                                            <th>#</th>
                                            <th>Tên đội</th>
                                            {{-- <th>Bài làm</th> --}}
                                            @hasanyrole('judge')
                                                <th>
                                                    Chấm bài
                                                </th>
                                            @endhasanyrole
                                            @hasanyrole(config('util.ROLE_ADMINS'))
                                                <th>Xác Nhận Điểm</th>
                                            @endhasanyrole
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $key = 1;
                                        @endphp
                                        @foreach ($round->teams as $team)
                                            <tr>
                                                <td>{{ $key++ }}</td>
                                                <td> <a
                                                        href="{{ route('admin.round.detail.team.detail', ['id' => $round->id, 'teamId' => $team->id]) }}">
                                                        {{ $team->name }}</a></td>

                                                {{-- <td>
                                                    <a href="{{ route('admin.round.detail.team.takeExam', ['id' => $round->id, 'teamId' => $team->id]) }}"
                                                        class="badge bg-primary p-3"> Xem thêm.
                                                    </a>
                                                </td> --}}
                                                @hasanyrole('judge')
                                                    <td>
                                                        <a class="badge bg-primary p-3"
                                                            href="{{ route('admin.round.detail.team.make.exam', ['id' => $round->id, 'teamId' => $team->id]) }}">Chấm
                                                            bài</a>
                                                    </td>
                                                @endhasanyrole
                                                @hasanyrole(config('util.ROLE_ADMINS'))
                                                    <td>
                                                        <a href="{{ route('admin.round.detail.team.judge', ['id' => $round->id, 'teamId' => $team->id]) }}"
                                                            class="badge bg-primary p-3"> Xác nhận điểm thi.
                                                        </a>
                                                    </td>
                                                @endhasanyrole
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class=" card card-flush ">
                <div class="row p-5 d-flex justify-content-center align-items-center ">
                    @hasanyrole(config('util.ROLE_ADMINS') . '|judge')
                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.round.detail.team', ['id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Đội thi</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($round->teams) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.result.index', ['id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Danh sách kết quả</span>
                                    </div>
                                    {{-- <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($round->exams) }}</span>
                                    </div> --}}
                                </div>
                            </a>
                        </div>
                    @endhasanyrole
                    @hasanyrole(config('util.ROLE_ADMINS'))
                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.judges.round', ['round_id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Ban giám khảo</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($round->judges) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.round.detail.enterprise', ['id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Doanh nghiệp tài trợ</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($round->Donor) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.exam.index', ['id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Đề bài</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($round->exams) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.round.send.mail', ['id' => $round->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Thông báo </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endhasanyrole
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $(".btn-show").hide();
            $(".btn-hide").on("click", function() {
                $(".list-team").hide(1000);
                $(this).hide();
                $(".btn-show").show(500);
            });


            $(".btn-show").on("click", function() {
                $(".list-team").show(1000);
                $(".btn-hide").show(500);
                $(this).hide();
            });
        })
    </script>
@endsection
