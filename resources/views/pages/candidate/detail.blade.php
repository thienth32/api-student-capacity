@extends('layouts.main')
@section('title', 'Chi tiết thông tin ứng tuyển')
@section('page-title', 'Chi tiết thông tin ứng tuyển')
@section('content')
    <div class=" mb-4">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb text-muted fs-6 fw-bold">
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.candidate.list') }}" class="pe-3">Thông tin ứng tuyển</a>
                    </li>
                    <li class="breadcrumb-item pe-3">
                        <a href="{{ route('admin.post.detail', ['slug' => $data->post->slug]) }}" class="pe-3">Mã tuyển dụng
                            : {{ $data->post->code_recruitment }}</a>
                    </li>
                    <li class="breadcrumb-item px-3 text-muted">SV:{{ $data->name }}</li>
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
                        {{-- <span class="fw-bolder text-white fs-2x mb-3">{{ $data->title }}</span>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <img style="width:100%"
                                    src="{{ $data->thumbnail_url ? $data->thumbnail_url : 'https://vanhoadoanhnghiepvn.vn/wp-content/uploads/2020/08/112815953-stock-vector-no-image-available-icon-flat-vector.jpg' }}" />

                            </div>
                        </div> --}}
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Họ tên </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Email </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Sđt </h3>
                                    </div>
                                    <div class="col-8">
                                        {{ $data->phone }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Mã tuyển dụng</h3>
                                    </div>
                                    <div class="col-8">
                                        <a class="btn btn-primary"
                                            href="{{ route('admin.post.detail', ['slug' => $data->post->slug]) }}">
                                            {{ $data->post->code_recruitment }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Ngày ứng tuyển</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($data->created_at)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($data->created_at)->diffforHumans() }}
                                        <br>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4 text-white mt-5">
                            <div class="opacity-75">
                                <div class="row">
                                    <div class="col-4">
                                        <h3>Ngày cập nhật</h3>
                                    </div>
                                    <div class="col-8">
                                        {{ date('d-m-Y H:i', strtotime($data->updated_at)) }}
                                        <br>
                                        {{ \Carbon\Carbon::parse($data->updated_at)->diffforHumans() }}
                                        <br>

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

                        <div style="width:100%" class=" fs-3 pb-5">

                            <div class="row mt-3">

                                <div class="col-md-5 mx-auto">
                                    <a target="_blank"
                                        href="{{ Storage::disk('s3')->temporaryUrl($data->file_link, now()->addMinutes(5)) }}">
                                        <div
                                            class="badge badge-primary badge-pill bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                            <div class="m-0  ">
                                                <span class="text-white-700 fw-bold fs-6">Xem CV</span>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-5 mx-auto">
                                    <a href="{{ route('dowload.file') . '?url=' . $data->file_link }}">
                                        <div
                                            class="badge badge-success badge-pill bg-opacity-70 rounded-2 px-6 py-5 d-flex justify-content-around">
                                            <div class="m-0  ">
                                                <span class="text-white-700 fw-bold fs-6">Tải CV </span>
                                            </div>

                                        </div>
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection
@section('page-script')
@endsection
