@extends('layouts.main')
@section('title', 'Chi tiết tuyển dụng')
@section('page-title', 'Chi tiết tuyển dụng')
@section('content')
    <div class=" mb-4">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.recruitment.list') }}" class="pe-3">Tuyển dụng</a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">{{ $data->name }}</li>
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
                        <span class="fw-bolder text-white fs-2x mb-3">{{ $data->name }}</span>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <img style="width:100%"
                                    src="{{ $data->image ? $data->image : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }}" />

                            </div>
                        </div>

                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Thời gian bắt đầu</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($data->start_time)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($data->start_time)->diffforHumans() }}
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
                                        {{ date('d-m-Y H:i', strtotime($data->end_time)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($data->end_time)->diffforHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Số lượng </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->amount }} người
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Mức lương </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ number_format($data->cost) }} $
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Quá trình</h3>
                                    </div>
                                    <div class="col-8">
                                        @if (\Carbon\Carbon::parse($data->start_time)->toDateTimeString() >
                                            \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString())
                                            <button type="button" class="btn btn-primary">Sắp diễn ra</button>
                                        @elseif (\Carbon\Carbon::parse($data->end_time)->toDateTimeString() >
                                            \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString())
                                            <button type="button" class="btn btn-success">Đang diễn ra</button>
                                        @else
                                            <button type="button" class="btn btn-danger">Đã kết thúc</button>
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
                        <h2 class="my-6">Thông tin tuyển dụng</h2>
                        <div style="width:100%" class=" fs-3 pb-5">
                            {!! $data->description !!}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection
@section('page-script')
@endsection
