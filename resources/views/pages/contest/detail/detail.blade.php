@extends('layouts.main')
@section('title', 'Quản lý cuộc thi')
@section('page-title', 'Quản lý cuộc thi')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <ol class="breadcrumb text-muted fs-6 fw-bold">
                <li class="breadcrumb-item pe-3">
                    <a href="{{ route('admin.contest.list') }}" class="pe-3">
                        Danh sách cuộc thi
                    </a>
                </li>
                <li class="breadcrumb-item px-3 text-muted">{{ $contest->name }}</li>
            </ol>
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
                        <span class="fw-bolder text-white fs-2x mb-3">{{ $contest->name }}</span>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <img style="width:100%"
                                    src="{{ $contest->img ? $contest->img : 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                                    alt="">
                            </div>
                        </div>

                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thời gian bắt đầu</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($contest->date_start)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($contest->date_start)->diffforHumans() }}
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
                                        {{ date('d-m-Y H:i', strtotime($contest->register_deadline)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($contest->register_deadline)->diffforHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thời gian mở đăng kí</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($contest->start_register_time)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($contest->start_register_time)->diffforHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thời gian đóng đăng kí</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($contest->end_register_time)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($contest->end_register_time)->diffforHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
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
                                        @elseif ($contest->status == 2)
                                            <button type="button" class="btn btn-primary">
                                                Đã kết thúc
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger">
                                                Không kích hoạt
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <hr>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        @if ($contest->status == 1 && strtotime($contest->register_deadline) < strtotime(now()))
                                            <a style="background-color: red !important" type="button"
                                                href="{{ route('contest.register.deadline', ['id' => $contest->id]) }}"
                                                class="btn btn-primary">
                                                Kết thúc cuộc thi
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xl-8 mb-5 mb-xl-10">

            <div class="container-fluid  card card-flush">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="my-6">Mô tả cuộc thi</h2>
                        <div style="width:100%" class=" fs-3 pb-5">
                            {!! $contest->description !!}
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
                                @forelse ($contest -> judges as $judge)
                                    <li class="list-group-item"> {{ $judge->name }}
                                        <small class="badge bg-success">{{ $judge->email }}</small>
                                    </li>
                                @empty
                                    Không có ban giám khảo !
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class=" card card-flush ">
                <div class="row p-5 d-flex justify-content-center align-items-center ">
                    @hasanyrole(config('util.ROLE_ADMINS') . '|judge')
                        <div class="col-md-3 mb-5">
                            <a
                                href="{{ route('admin.contest.detail.round', ['id' => $contest->id], 'contest_id=' . $contest->id) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Vòng thi</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($contest->rounds) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endhasanyrole
                    @hasanyrole(config('util.ROLE_ADMINS'))
                        <div class="col-md-3  mb-5">
                            <a href="{{ route('admin.contest.detail.team', ['id' => $contest->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Đội thi</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($contest->teams) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3  mb-5">
                            <a href="{{ route('admin.judges.contest', ['contest_id' => $contest->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Ban giám khảo</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($contest->judges) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3  mb-5">
                            <a href="{{ route('admin.contest.detail.enterprise', ['id' => $contest->id]) }}">
                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                    <div class="m-0">
                                        <span class="text-gray-700 fw-bold fs-6">Doanh nghiệp tài trợ</span>
                                    </div>
                                    <div class="m-0 badge badge-primary badge-pill">
                                        <span class=" fs-6 text-white">{{ count($contest->enterprise) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-5">
                            <a href="{{ route('admin.contest.send.mail', ['id' => $contest->id]) }}">
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
@endsection
